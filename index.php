<?php
	// Start output buffering:
	ob_start();
	// Initialize a session:
	session_start();
	include 'header.html';
	$tab=1;
	require  "menu.php";
?>   
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
	<script type="text/javascript" src="map.js"></script>
	
    <div id="top_panel">
    	<div id="map_canvas"></div>
    	<br><br>
    </div> <!-- end of top panel -->
    
    <div id="templatemo_bottom_panel">
    
    	<div class="bottom_panel_section">
			<div class="news_section">
            	<div class="bottom_section_title">Site News</div>
                
                <div class="news_title">News Item One</div>
                <p>Lorem ipsum dolor sit amet, massa quisque eros, lacus per integer. Hic minima conubia, a venenatis, suscipit convallis. <a href="#">read more</a></p>
                
                <div class="cleaner_h30">&nbsp;</div>
                
                <div class="news_title">News Item Two</div>
                <p> Tortor mattis molestie, dolor donec, mauris amet. Ornare purus integer, et etiam ultricies, quam quis elementum.  <a href="#">read more</a></p>
               	
              <div class="cleaner_h10">&nbsp;</div>
                <div class="templatemo_btn_02"><a href="#">read more</a></div>
            </div>
            
            <div class="cleaner">&nbsp;</div>
        </div>
        
        <div class="bottom_panel_section">
			<div class="service_section">
	            <div class="bottom_section_title">Web Design Services</div>
              <p>Personal   website template is brought to you by <a title="free website templates" href="http://www.templatemo.com" target="_parent">templatemo.com</a> for free of charge. You may use it  for your websites.</p>
                
              <div class="cleaner_h20">&nbsp;</div>
                <ul>
                	<li>Augue diam nullam</li>
                    <li>Risus pharetra vitae</li>
                    <li>Nulla tincidunt, dui eget</li>
                    <li><a href="http://www.templatemo.com" target="_parent">Free  Website Templates</a></li>
                  <li><a href="http://www.flashmo.com" target="_parent">Free Flash Templates</a></li>  
                    <li><a href="http://www.photovaco.com" target="_parent">Free Stock Photos</a></li>                   
                </ul>
                
                <div class="cleaner_h10">&nbsp;</div>
                <div class="templatemo_btn_02"><a href="#">read more</a></div>
            </div>
            <div class="cleaner">&nbsp;</div>
        </div>
        
        <div class="bottom_panel_section">
        	<div class="bottom_section_title">About the author</div>
      <div class="image_box">
            	<div class="image_box_02">
            		<img src="images/templatemo_image_01.gif" alt="css template" />
                </div>
            </div>
            <p>Phasellus quisque lacinia. Amet in arcu, at class magna. Rutrum neque sit, eu viverra, neque ut. <a href="#">read more</a></p>
            
          <div class="cleaner_h10">&nbsp;</div>
            <a href="http://validator.w3.org/check?uri=referer"><img style="border:0;width:88px;height:31px" src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" width="88" height="31" vspace="8" border="0" /></a>
<a href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px"  src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="Valid CSS!" vspace="8" border="0" /></a> 
	            
		  <div class="cleaner">&nbsp;</div>
        </div>
        
        <div class="cleaner_h20">&nbsp;</div>    
    </div> <!-- end of bottom panel -->
<?php
	include 'footer.html';
?>
