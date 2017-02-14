<?php do_action( 'ct_tribes_main_bottom' ); ?>
</section> <!-- .main -->

<?php do_action( 'ct_tribes_after_main' ); ?>

<footer id="site-footer" class="site-footer" role="contentinfo">
    <?php do_action( 'ct_tribes_footer_top' ); ?>
    <div class="design-credit">
        <span>
            <?php
            $footer_text = sprintf( __( '<a href="%1$s">%2$s WordPress Theme</a> by Compete Themes.', 'tribes' ), 'https://www.competethemes.com/tribes/', wp_get_theme( get_template() ) );
            $footer_text = apply_filters( 'ct_tribes_footer_text', $footer_text );
            echo wp_kses_post( $footer_text );
            ?>
        </span>
    </div>
</footer>
</div><!-- .max-width -->
</div><!-- .theme-container -->
</div><!-- .overflow-container -->

<?php do_action( 'ct_tribes_body_bottom' ); ?>

<?php wp_footer(); ?>

</body>
</html>