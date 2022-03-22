<div class="video-wrapper">
    <?php if (key_exists('videoUrl', $employer) && strlen($employer['videoUrl']) > 0) : ?>
        <video preload="metadata" <?= $controls ? 'controls' : '' ?> <?= $autoplay ? 'autoplay' : '' ?> <?= $loop ? 'loop' : '' ?>>
            <source src="<?= $employer['videoUrl'] ?>" type="video/mp4">
            <p>Your browser doesn't support HTML5 video. Here is
                a <a href="<?= $employer['videoUrl'] ?>">link to the video</a> instead.</p>
        </video>
    <?php endif; ?>
</div>