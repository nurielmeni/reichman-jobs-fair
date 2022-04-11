<?php if (key_exists('videoUrl', $employer) && strlen($employer['videoUrl']) > 0) : ?>
    <?php if (strpos($employer['videoUrl'], 'youtu.be')) : ?>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= end(explode('/', $employer['videoUrl'])) ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
        </iframe>
    <?php elseif (strpos($employer['videoUrl'], '.mp4')) : ?>
        <div class="video-wrapper">
            <video preload="metadata" <?= $controls ? 'controls' : '' ?> <?= $autoplay ? 'autoplay' : '' ?> <?= $loop ? 'loop' : '' ?>>
                <source src="<?= $employer['videoUrl'] ?>" type="video/mp4">
                <p>Your browser doesn't support HTML5 video. Here is
                    a <a href="<?= $employer['videoUrl'] ?>">link to the video</a> instead.</p>
            </video>
        </div>
    <?php endif; ?>
<?php endif; ?>