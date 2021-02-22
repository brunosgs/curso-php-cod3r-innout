<?php
if ($exception) {
    $message = [
        'type' => 'erro',
        'message' => $exception->getMessage()
    ];
}
?>

<?php if (isset($message)) : ?>
    <div class="alert alert-danger my-3" role="alert">
        <?= $message['message'] ?>
    </div>
<?php endif ?>