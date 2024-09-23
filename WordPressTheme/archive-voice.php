<?php get_header(); ?>
<main>
  <section class="page-head">
    <h1 class="page-head__title">Voice</h1>
    <div class="page-head__image">
      <picture>
        <source srcset="<?php echo get_theme_file_uri(); ?>/assets/images/voice/voice-img.jpg" alt="ダイビングの写真"
          media="(min-width: 768px)" />
        <img src="<?php echo get_theme_file_uri(); ?>/assets/images/voice/voice-img_sp.jpg" alt="" />
      </picture>
    </div>
  </section>
  <nav class="breadcrumbs breadcrumbs--top-margin">
    <div class="breadcrumb__inner inner">
      <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
        <?php if (function_exists('bcn_display')) {
          bcn_display();
        } ?>
      </div>
    </div>
  </nav>
  <div class="voice-section voice-section--top-margin page-body">
    <div class="voice-section__inner inner">
      <div class="voice-section__tags category-tags">
        <ul class="category-tags__list">
          <li
            class="category-tags__item category-tag <?php if (is_post_type_archive('voice')) echo 'category-tag--active'; ?>">
            <a href="<?php echo get_post_type_archive_link('voice'); ?>">ALL</a>
          </li>
          <?php
          $terms = get_terms(array(
            'taxonomy' => 'voice_category',
            'hide_empty' => false,
          ));
          foreach ($terms as $term) {
            echo '<li class="category-tags__item category-tag"><a href="' . get_term_link($term) . '">' . $term->name . '</a></li>';
          }
          ?>
        </ul>
      </div>
      <div class="voice-section__content">
        <div class="voice__items voice-cards">
          <?php
          $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
          $args = array(
            'post_type' => 'voice',
            'paged' => $paged,
            'posts_per_page' => 6,
          );
          $the_query = new WP_Query($args);
          if ($the_query->have_posts()) :
            while ($the_query->have_posts()) :
              $the_query->the_post(); ?>
              <section class="voice-cards__item voice-card">
                <div class="voice-card__head">
                  <div class="voice-card__meta">
                    <div class="voice-card__metahead">
                      <p class="voice-card__age"><?php the_field('age'); ?>代(<?php the_field('gender'); ?>)</p>
                      <p class="voice-card__category category-tag">
                        <?php
                        $terms = get_the_terms(get_the_ID(), 'voice_category');
                        if ($terms && !is_wp_error($terms)) {
                          $term_links = array();
                          foreach ($terms as $term) {
                            $term_links[] = '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
                          }
                          echo join(", ", $term_links);
                        }
                        ?></p>
                    </div>
                    <h2 class="voice-card__title">
                      <?php the_title(); ?>
                    </h2>
                  </div>
                  <div class="voice-card__image js-slidein">
                    <?php if (has_post_thumbnail()) : ?>
                      <?php the_post_thumbnail('full', ['alt' => get_the_title()]); ?>
                    <?php endif; ?>
                  </div>
                </div>
                <p class="voice-card__text">
                  <?php the_content(); ?>
                </p>
              </section>
            <?php endwhile; ?>
        </div>
        <div class="pagination pagination--top-margin">
          <?php
            if (function_exists('wp_pagenavi')) {
              wp_pagenavi(array('query' => $the_query));
            }
            wp_reset_postdata(); ?>
        </div>
      <?php endif; ?>
      </div>
    </div>
  </div>
  <?php get_footer(); ?>