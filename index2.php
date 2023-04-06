<?php
if (isset($_POST['calculate'])) {
    $input = $_POST['input'];
    $result = eval('return '.$input.';');
}
?>
    <form method="POST">
        <input type="text" name="input" value="<?php echo isset($input) ? $input : ''; ?>">
        <button type="submit" name="calculate">Calculate</button>
    </form>
<?php if (isset($result)): ?>
<p>Result: <?php echo $result; ?></p>
<?php endif; ?>