<?php get_header('id_'.$_GET['id']); ?>
<h1><?php echo cs_page_title($_GET['id']); ?></h1>
<?php echo cs_page_content($_GET['id']); ?>
<?php get_footer(); ?>