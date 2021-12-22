<?php echo $header; ?> 
   <div id="content">
            <div id="content_container">
                <div id="content_area">
                    <div class="sidebar_right_without_top_margin">
                        <div class="grey_box_narrow">
                            <div class="grey_box_top"></div>
                            <div class="grey_box_title">Give us your feedback</div>
                            <div class="grey_box_content">
                                <div class="small">
                                    If you find us good or bad, please
                                    Do let us know about your thoughts. So we improve our services.<br/>
                                    <a href="index.php?route=cms/contact" class="dark_blue">contact us</a>
                                </div>
                            </div>
                            <div class="grey_box_bottom"></div>
                        </div>
                    </div>
                    
                    <div class="content_with_left_sidebar">
                        <h2 class="subtitle_with_border"><?php echo (($detail['title'])) ?></h2>
                        <?php echo html_entity_decode($detail['description'])?>
                       
                        
                        <div class="clear"></div>
                    </div><!--.content_with_left_sidebar-->
                    
                    <div class="clear"></div>
                </div><!--#content_area-->
            </div><!--#content_container-->
        </div><!--#content-->

<?php echo $footer; ?> 