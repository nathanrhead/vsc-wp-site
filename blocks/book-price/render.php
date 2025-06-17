<?php
$post_id = $block->context['postId'] ?? get_the_ID();

if (!$post_id) return '';

$price = get_post_meta($post_id, 'book_price', true);
$e_price = get_post_meta($post_id, 'ebook_price', true);
?>

<div class="book-price-container">
  <?php if ($price): ?><p class="book-price">Paperback: <?= esc_html($price) ?></p><?php endif; ?>
  <?php if ($e_price): ?><p class="ebook-price">eBook: <?= esc_html($e_price) ?></p><?php endif; ?>
</div>