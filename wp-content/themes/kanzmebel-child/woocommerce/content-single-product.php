<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
     <div class="container">
	    <div id="product-main-info">
        <?php
        /**
         * Hook: woocommerce_before_single_product_summary.
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */
        do_action( 'woocommerce_before_single_product_summary' );
        ?>

        <div class="d-flex flex-column" id="characters">
            <div id="product-main-data">
                <h1 itemprop="name" class="product_name"><?=$product->get_title();?></h1>

                <div class="product_meta">
                    <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

                        <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>

                    <?php endif; ?>

                    <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
                </div>

                <div id="product-main-data-price">
                    <?php
                    /**
                     * Hook: woocommerce_single_product_summary.
                     *
                     * @hooked woocommerce_template_single_title - 5
                     * @hooked woocommerce_template_single_rating - 10
                     * @hooked woocommerce_template_single_price - 10
                     * @hooked woocommerce_template_single_excerpt - 20
                     * @hooked woocommerce_template_single_add_to_cart - 30
                     * @hooked woocommerce_template_single_meta - 40
                     * @hooked woocommerce_template_single_sharing - 50
                     * @hooked WC_Structured_Data::generate_product_data() - 60
                     */
                    do_action( 'woocommerce_single_product_summary' );
                    ?>
                </div>
            </div>

            <div id="product-characters">
                <?php
                /**
                 * Hook: woocommerce_after_single_product_summary.
                 *
                 * @hooked woocommerce_output_product_data_tabs - 10
                 * @hooked woocommerce_upsell_display - 15
                 * @hooked woocommerce_output_related_products - 20
                 */
                do_action( 'woocommerce_after_single_product_summary' );
                ?>
            </div>
        </div>

        <div id="related_products">
            <?php do_action('kanzmebel_get_related_products');?>
        </div>
    </div>

        <?php
            $product_descriptions = get_field('о_товаре',$product->get_id());
             $descriptions_counter = 0;
        ?>
        <?php if( isset($product_descriptions['о_товаре']) && count($product_descriptions['о_товаре']) > 0 ): ?>
        <div id="product-description">
            <div class="accordion" id="product-description-accordion">
                <?php
                    foreach ($product_descriptions['о_товаре'] as $product_description):
                ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?=$descriptions_counter;?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$descriptions_counter;?>" aria-expanded="true" aria-controls="collapse<?=$descriptions_counter;?>">
                                <?=$product_description['заголовок'];?>
                            </button>
                        </h2>
                        <div id="collapse<?=$descriptions_counter;?>" class="accordion-collapse collapse" aria-labelledby="heading<?=$descriptions_counter;?>" data-bs-parent="#product-description-accordion">
                            <div class="accordion-body">
                                <?=htmlspecialchars_decode($product_description['описание']);?>
                            </div>
                        </div>
                    </div>
                <?php $descriptions_counter++ ;endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    </div>
    <section class="additional-data" style="background-color: #EFEEED; margin-top: 30px;">
        <div class="container">
            <div class="section-data">
                <p>Нужен другой размер, цвет, хотите
                    поменять ручки или не нашли
                    подходящую модель? — Мы сделаем
                    для вас уникальную мебель по
                    индивидуальным параметрам</p>

                <a href="#" class="btn link_btn" data-bs-toggle="modal" data-bs-target="#writeUs">Оставить заявку</a>
            </div>
        </div>
    </section>

</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
