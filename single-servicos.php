<?php
 /*Template Name: Template para os servicos
 */
?>

<?php do_action( '__before_main_wrapper' ); ##hook of the header with get_header ?>
<div id="main-wrapper" class="<?php echo tc__f( 'tc_main_wrapper_classes' , 'container' ) ?>">

    <?php do_action( '__before_main_container' ); ##hook of the featured page (priority 10) and breadcrumb (priority 20)...and whatever you need! ?>
    
    <div class="container" role="main">
        <div class="<?php echo tc__f( 'tc_column_content_wrapper_classes' , 'row column-content-wrapper' ) ?>">

            <?php do_action( '__before_article_container'); ##hook of left sidebar?>
                
                <div id="content" class="<?php echo tc__f( '__screen_layout' , tc__f ( '__ID' ) , 'class' ) ?> article-container">
                    
                    <?php do_action ('__before_loop');##hooks the header of the list of post : archive, search... ?>

			    <?php
			    $mypost = array( 'post_type' => 'servicos', );
			    $loop = new WP_Query( $mypost );
			    ?>
			    <?php while ( $loop->have_posts() ) : $loop->the_post();?>
			        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			            <header class="entry-header">
			 
			                <!-- Display featured image with zoom transition -->
			                
			                <a id="top"></a>
			                <div class="span3">
			                    <div class="widget-front">
			                	<div class="bloco">
			                          <a class="round-div smoothScroll" href="#<?php the_title(); ?>" title="<?php the_title();?>"></a>
			            		  <?php the_post_thumbnail(array( 220, 200));?>
			 			</div>
			 			
				       		<!-- fim display of image -->
			
				        	<h4><?php the_title(); ?></h4>
			        	   </div> 
			    	       </div> 
			    	       
			        </article>
			 
			    <?php endwhile; ?>
			    
			    <hr style="width:100;">
			    
			    <?php
			    $mypost = array( 'post_type' => 'servicos', );
			    $loop = new WP_Query( $mypost );
			    ?>
			    <?php while ( $loop->have_posts() ) : $loop->the_post();?>
			        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			        <div id="content" class="<?php echo tc__f( '__screen_layout' , tc__f ( '__ID' ) , 'class' ) ?> article-container">     	 
			                <!-- Display boxes -->
			            <div class="caixa" style="background:<?php echo esc_html( get_post_meta( get_the_ID(), 'meta-color', true ) ); ?>">
			                <div class="floatleft">
			                    <a id="<?php the_title(); ?>"></a>
			                    <h4><?php the_title() ?></h4>
			                    <?php the_post_thumbnail(array( 75, 75));?>
			                </div>
			                <div class="centro">
			                     <?php the_excerpt();?>
			                     <a class="btn btn-primary fp-button" href="#">ver mais</a> 
			                </div>
			                <div class="floatright">
			                <a href="#top" class="smoothScroll">Top</a> 
			                		
			            </div>    
			                
			                
			    	</div>       
			        </article>
			 
			    <?php endwhile; ?>

                    <?php do_action ('__after_loop');##hook of the comments and the posts navigation with priorities 10 and 20 ?>

                </div><!--.article-container -->

           <?php do_action( '__after_article_container'); ##hook of left sidebar ?>

        </div><!--.row -->
    </div><!-- .container role: main -->

    <?php do_action( '__after_main_container' ); ?>

</div><!--#main-wrapper"-->

<?php do_action( '__after_main_wrapper' );##hook of the footer with get_get_footer ?>
