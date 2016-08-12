<?php 
/**
 * Portfolio Extra Information
 */ ?>

	
	<?php 
	$meta = '';
	global $ioa_super_options,$ioa_portfolio_taxonomy,$ioa_portfolio_slug;
	$portfolio_fields = $ioa_super_options[SN.'_single_portfolio_meta'];

		if($portfolio_fields!="")
		{
			$portfolio_fields = explode(';',$portfolio_fields);
			$inps = array();
			foreach($portfolio_fields as $field)
			{
				if(trim($field)!="") :
					$key = str_replace(' ','_',strtolower(trim($field)));
					$value = stripslashes(get_post_meta(get_the_ID(),$key,true));

					if(trim($value)!="")
						$meta .= "<div class='meta-item clearfix'><strong itemprop='name'>$field</strong> : <span itemprop='description'> $value </span></div> ";
				endif;
			}
			
		
		}


	 ?>					

<?php if(trim($meta)!="") : ?>
<div class="meta-info clearfix" itemscope itemtype="http://schema.org/ItemList">
	 <div class="like-icon-wrap">
                     <i class="like-icon ioa-front-icon heart-2icon-" data-id="<?php echo get_the_ID() ?>" ></i>
                     <span class="p-counter"><?php echo get_post_meta(get_the_ID(),'_ioa_likes',true) ?></span>
      </div>
	<?php echo $meta; ?>
</div>	
<?php endif; ?>