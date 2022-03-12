<?php if ($tags && is_array($tags)) : ?>
    <?php foreach ($tags as $tag) : ?>
        <span class="md:text-lg bg-chip text-primary rounded-lg px-2"><?= $tag ?></span>
    <?php endforeach; ?>
<?php endif; ?>