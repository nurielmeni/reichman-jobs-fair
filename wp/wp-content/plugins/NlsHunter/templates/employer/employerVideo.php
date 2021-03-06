<?php $videoUrlParts = explode('/', $employer->videoUrl); ?>
<?php if (property_exists($employer, 'videoUrl') && strlen($employer->videoUrl) > 0) : ?>
    <?php if (strpos($employer->videoUrl, 'youtu.be')) : ?>
        <div class="youtube-player-container">
            <iframe src="https://www.youtube.com/embed/<?= end($videoUrlParts) ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="video">
            </iframe>
        </div>
    <?php elseif (strpos($employer->videoUrl, '.mp4')) : ?>
        <div class="video-wrapper">
            <video preload="metadata" <?= $controls ? 'controls' : '' ?> <?= $autoplay ? 'autoplay' : '' ?> <?= $loop ? 'loop' : '' ?>>
                <source src="<?= $employer->videoUrl ?>" type="video/mp4">
                <p>Your browser doesn't support HTML5 video. Here is
                    a <a href="<?= $employer->videoUrl ?>">link to the video</a> instead.</p>
            </video>
        </div>
    <?php endif; ?>
<?php endif; ?>