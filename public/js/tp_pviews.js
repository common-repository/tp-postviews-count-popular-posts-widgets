/**
 * ThemePacific Scripts for tp_postviews Plugin
 *
 * @package WordPress
 * @Author Raja CRN
 * @since  1.0
 */
jQuery(document).ready(function() {
   		jQuery.ajax({
			type: "post",
			url: tp_postviews.url,
			data:{
               'action':'tp_postviews' ,nonce:tp_postviews.nonce,pid:tp_postviews.pid           
               },  
 		});
});