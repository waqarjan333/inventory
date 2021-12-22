<?php echo $header; ?> 
  <div id="content">
            <div id="content_container">
                <div id="content_area">
                    <div class="sidebar_right_without_top_margin">
                        <div class="grey_box_narrow">
                            <div class="grey_box_top"></div>
                            <div class="grey_box_title">Customer Support</div>
                            <div class="grey_box_content">
                                +971 4 123 4567<br/>
                                <a href="#" class="blue">support@hawklinks.com</a>
                                <div class="box15px"></div>
                                <b>Sales</b><br/>
                                +971 4 123 4567<br/>
                                <a href="#" class="blue">sales@hawklinks.com</a>
                                <div class="box15px"></div>
                                <b>Press Release</b><br/>
                                +971 4 123 4567<br/>
                                <a href="#" class="blue">press@hawklinks.com</a>
                                <div class="box15px"></div>
                                <b>Business Development</b><br/>
                                +971 4 123 4567<br/>
                                <a href="#" class="blue">bd@hawklinks.com</a>
                                <div class="box10px"></div>
                            </div>
                            <div class="grey_box_bottom"></div>
                        </div>
                    </div>
                    
                    <div class="sidebar_left">
                        <div class="sidebar_contact_page_title">We are Located</div>
                        <div class="box15px"></div>
                        <b><?php echo $site; ?></b><br/>
                        <?php echo $address; ?>
                        <div class="box20px"></div>
                        Phone: <?php echo $telephone; ?><br/>
                        <?php if ($fax) { ?> Fax: <?php echo $fax; } ?>
                        <div class="box10px"></div>
                        <img src="themes/hawklink/images/google_map.png" alt=""/>
                    </div>
                    
                    <div class="content_with_two_sidebars">
                        <div id="contact_form">
                            <h2 class="subtitle">Contact us</h2>

                            <form action="" method="post">
                                <fieldset>
                                    <select name="subject" id="subject">
                                        <option value="">Select your subject</option>
                                    </select>

                                    <div class="form_textinput">
                                        <input type="text" name="name" value="<?php echo $name; ?>" title="Name"/>
                                    </div>

                                    <div class="form_textinput">
                                        <input type="text" name="email" value="<?php echo $email; ?>" title="Email"/>
                                    </div>

                                    <div class="request_textarea">
                                        <textarea name="enquiry" id="enquiry" cols="20" rows="6"><?php echo $enquiry; ?></textarea>
                                    </div>
                                    <div class="box5px"></div>
                                    <input type="image" name="send" value="Send" src="themes/hawklink/images/send.png"/>
                                </fieldset>
                            </form>
                        </div>
                        
                        <div class="clear"></div>
                    </div><!--.content_with_left_sidebar-->
                    
                    <div class="clear"></div>
                </div><!--#content_area-->
            </div><!--#content_container-->
        </div><!--#content-->

<?php echo $footer; ?> 