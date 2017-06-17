<?php foreach ($messages as $key => $message): ?>
<?php if (is_array($message)): ?>
<?php
print_r($message);
?>
<?php else: ?>
<?= $message . "\n" ?>
<?php endif; ?>
<?php endforeach; ?>
