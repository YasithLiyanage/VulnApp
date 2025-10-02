<?php echo "cwd: ".getcwd()."\n"; echo "pwd: ".realpath(__DIR__.'/../..')."\n"; echo nl2br(shell_exec('ls -la ..')); ?>
