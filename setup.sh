# on the VM
sudo tee /tmp/setup_vulnapp.sh > /dev/null <<'SH'
#!/usr/bin/env bash
set -euo pipefail

# ------------- CONFIG (edit as needed) -------------
GIT_REPO="https://github.com/YasithLiyanage/VulnApp.git"
APPDIR="/var/www/html/vulnapp"
INSTRUCTOR_DIR="/root/instructor_files"
UPLOADS_DIR="$APPDIR/uploads"
SECRET_DIR="/var/www/secret"
DBFILE="$APPDIR/data.db"
STUDENT_USER="student"
STUDENT_PASS="changeme123!"
WEB_USER="www-data"
MAX_RETRY=3
# ---------------------------------------------------

echo "==> Starting VulnApp setup"

# must run as root
if [ "$(id -u)" -ne 0 ]; then
  echo "This script must be run as root. Use sudo." >&2
  exit 2
fi

# Update & install packages
echo "==> Installing packages (apache2, php, sqlite3, git, php-sqlite3, php-xml, php-mbstring)"
apt-get update -y
apt-get install -y apache2 git sqlite3 php php-sqlite3 php-xml php-mbstring unzip

# Enable apache mods that are often useful
a2enmod rewrite headers >/dev/null 2>&1 || true

# Clone or update repo
if [ -d "$APPDIR" ]; then
  echo "==> $APPDIR exists — pulling latest from repo"
  if [ -d "$APPDIR/.git" ]; then
    git -C "$APPDIR" pull || true
  else
    mv "$APPDIR" "${APPDIR}.bak.$(date +%s)" || true
    git clone --depth 1 "$GIT_REPO" "$APPDIR"
  fi
else
  echo "==> Cloning repo into $APPDIR"
  mkdir -p "$(dirname "$APPDIR")"
  git clone --depth 1 "$GIT_REPO" "$APPDIR"
fi

# Ensure webroot index exists
if [ ! -f "$APPDIR/index.php" ] && [ ! -f "$APPDIR/index.html" ]; then
  echo "<html><body><h1>VulnApp placeholder</h1></body></html>" > "$APPDIR/index.html"
fi

# Create uploads dir and ensure web user owns it
mkdir -p "$UPLOADS_DIR"
chown -R "$WEB_USER:$WEB_USER" "$UPLOADS_DIR"
chmod 2775 "$UPLOADS_DIR"    # group write and setgid so webserver owns new files

# Create secret dir and seed flag (instructor should change)
mkdir -p "$SECRET_DIR"
chown root:"$WEB_USER" "$SECRET_DIR"
chmod 750 "$SECRET_DIR"
FLAG_CONTENT="flag4_$(head -c6 /dev/urandom | od -An -tx1 | tr -d ' \n')"
echo "flag{${FLAG_CONTENT}}" > "$SECRET_DIR/flag4.txt"
chown root:"$WEB_USER" "$SECRET_DIR/flag4.txt"
chmod 640 "$SECRET_DIR/flag4.txt"

# Move instructor-only files out of webroot if found
mkdir -p "$INSTRUCTOR_DIR"
chmod 700 "$INSTRUCTOR_DIR"
# heuristics: filenames that often hold sensitive data
for f in flags_instructor.txt create_db.php .env data-init.sql secret.txt flag*.txt; do
  if [ -f "$APPDIR/$f" ]; then
    echo "==> Moving $APPDIR/$f to $INSTRUCTOR_DIR/"
    mv -f "$APPDIR/$f" "$INSTRUCTOR_DIR/"
    chmod 600 "$INSTRUCTOR_DIR/$(basename "$f")"
  fi
done

# If repository included a data-init.sql, move to instructor dir and initialize DB from it if DB missing
if [ -f "$APPDIR/data-init.sql" ]; then
  echo "==> Found data-init.sql in repo; copying to instructor dir for safekeeping."
  mv -f "$APPDIR/data-init.sql" "$INSTRUCTOR_DIR/data-init.sql"
  chmod 600 "$INSTRUCTOR_DIR/data-init.sql"
fi

# Create sqlite DB if not present, using data-init.sql if available
if [ ! -f "$DBFILE" ]; then
  if [ -f "$INSTRUCTOR_DIR/data-init.sql" ]; then
    echo "==> Initializing SQLite DB from $INSTRUCTOR_DIR/data-init.sql"
    sqlite3 "$DBFILE" < "$INSTRUCTOR_DIR/data-init.sql"
  else
    echo "==> No data-init.sql found; creating empty DB"
    sqlite3 "$DBFILE" "VACUUM;"
  fi
fi

# Ensure DB ownership and permissions
chown "$WEB_USER:$WEB_USER" "$DBFILE" || true
chmod 660 "$DBFILE" || true

# Set ownership and permissions for app files
chown -R root:"$WEB_USER" "$APPDIR"
find "$APPDIR" -type d -exec chmod 750 {} \;
find "$APPDIR" -type f -exec chmod 640 {} \;
# allow webserver write to uploads
chown -R "$WEB_USER:$WEB_USER" "$UPLOADS_DIR"
chmod -R 2775 "$UPLOADS_DIR"

# Create student account with no shell
if ! id -u "$STUDENT_USER" >/dev/null 2>&1; then
  echo "==> Creating student user ($STUDENT_USER)"
  adduser --disabled-password --gecos "Student,,," "$STUDENT_USER" >/dev/null || true
  echo "${STUDENT_USER}:${STUDENT_PASS}" | chpasswd
  usermod -s /usr/sbin/nologin "$STUDENT_USER" || true
  deluser "$STUDENT_USER" sudo 2>/dev/null || true
fi

# Systemd unit to ensure apache restarts after network-online.target
cat > /etc/systemd/system/apache2-wait-net.service <<'UNIT'
[Unit]
Description=Ensure Apache is restarted after network is ready
After=network-online.target
Wants=network-online.target
Requires=apache2.service

[Service]
Type=oneshot
ExecStart=/bin/systemctl restart apache2
RemainAfterExit=true

[Install]
WantedBy=multi-user.target
UNIT

systemctl daemon-reload
systemctl enable --now apache2 apache2-wait-net.service

# Optional: disable SSH (comment out if you want SSH enabled)
# systemctl disable --now ssh || true

# Zero-free-space for smaller OVA (optional, commented)
# dd if=/dev/zero of=/zerofile bs=1M || true; sync; rm -f /zerofile; sync

echo "==> Setup complete."

# Final verification
echo
echo "== Quick checks =="
echo "- Apache active: $(systemctl is-active apache2 2>/dev/null || echo no)"
echo "- App dir: $APPDIR"
echo "- Uploads dir: $UPLOADS_DIR"
echo "- Secret dir & flag: $SECRET_DIR/flag4.txt"
echo "- DB file: $DBFILE (owner: $(stat -c '%U:%G' "$DBFILE" 2>/dev/null || echo unknown))"

echo
echo "== To test manually =="
echo "1) Open http://<vm-ip>/vulnapp/ in your browser"
echo "2) SQLi page: http://<vm-ip>/vulnapp/sqli.php"
echo "3) XSS page:  http://<vm-ip>/vulnapp/xss.php"
echo "4) IDOR page: http://<vm-ip>/vulnapp/idor.php?user=1"
echo "5) Upload page: http://<vm-ip>/vulnapp/upload.php"
echo
echo "Instructor files (moved out of webroot) live in: $INSTRUCTOR_DIR"
echo "If you want to re-enable SSH, run: sudo systemctl enable --now ssh"

SH

chmod +x /tmp/setup_vulnapp.sh
echo "Run: sudo /tmp/setup_vulnapp.sh"
