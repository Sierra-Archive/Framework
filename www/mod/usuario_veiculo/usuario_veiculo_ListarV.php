<?php

class usuario_veiculo_ListarVisual extends usuario_veiculo_Visual
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct() {
      parent::__construct();
    }
    /**
     * 
     * @param type $array
     * @return string
     */
    static function Show_Veiculos(&$array) {
        GLOBAL $config;
        $Registro = &\Framework\App\Registro::getInstacia();
        $Visual = &$Registro->_Visual;
        $html = '<div class="megaexamples">
                                <!--  FILTER STYLED  -->
                                <div class="filter_padder" >
                                    <div class="filter_wrapper">
                                        <div class="filter selected" data-category="cat-all">ALL</div>
                                        <div class="filter" data-category="cat-one">CATEGORY ONE</div>
                                        <div class="filter" data-category="cat-two">CATEGORY TWO</div>
                                        <div class="filter" data-category="cat-three">CATEGORY THREE</div>
                                        <div class="filter last-child" data-category="cat-four">CATEGORY FOUR</div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="metro-gallery">
                                    <!-- The GRID System -->
                                    <div class="metro-gal-container noborder norounded dark-bg-entries">

                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-two cat-all" id="mega-entry-1" data-src="img/gallery/image1.jpg" data-width="780" data-height="585" data-lowsize="">

                                        <div class="mega-covercaption mega-square-bottom mega-landscape-right mega-portrait-bottom mega-red">
                                            <!-- The Content Part with Hidden Overflow Container -->

                                            <div class="mega-title"><img src="img/gallery/icons/grid.png" alt="" style="float: left; padding-right: 15px;"/>Good for Nothing</div>
                                            <div class="mega-date">Lorem ipsun dolor</div>
                                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua...<br/><br/><a href="#">Read the whole story</a></p>

                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-red"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image1.jpg" title="Good for Nothing"><div class="mega-view mega-red"></div></a>
                                        </div>

                                    </div>


                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-one cat-all"  id="mega-entry-2"  data-src="img/gallery/image2.jpg" data-width="780" data-height="385" data-lowsize="">

                                        <div class="mega-covercaption mega-square-bottom mega-landscape-left mega-portrait-bottom mega-orange mega-white ">

                                            <div class="mega-title">Might is Right</div>
                                            <div class="mega-date">loerm sum doleo</div>
                                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt...</p>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-orange"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image2.jpg" title="Too Much !"><div class="mega-view mega-orange"></div></a>
                                        </div>

                                    </div>


                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-three cat-all"  id="mega-entry-3" data-src="img/gallery/image3.jpg" data-width="780" data-height="485">

                                        <div class="mega-covercaption mega-square-bottom mega-landscape-bottom mega-portrait-bottom mega-turquoise ">
                                            <div class="mega-title"><img src="img/gallery/icons/flexible.png" alt="" style="float: left; padding-right: 15px;"/>Honesty</div>
                                            <div class="mega-date">Lorem ispusn ament</div>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-turquoise"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image3.jpg" title="Might is right"><div class="mega-view mega-turquoise"></div></a>
                                        </div>

                                    </div>

                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-four cat-all"  id="mega-entry-4" data-src="img/gallery/image4.jpg" data-width="680" data-height="685">

                                        <div class="mega-covercaption mega-square-bottom mega-landscape-bottom mega-portrait-bottom mega-black ">
                                            <div class="mega-title">Hi this is Sam</div>
                                            <div class="mega-date">Lorem ipsum dolor sit</div>
                                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt...</p>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-black"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image4.jpg" title="Do the Best"><div class="mega-view mega-black"></div></a>
                                        </div>

                                    </div>

                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-one cat-all"  id="mega-entry-5" data-src="img/gallery/image5.jpg" data-width="780" data-height="585">

                                        <div class="mega-covercaption mega-square-bottom mega-landscape-bottom mega-portrait-bottom mega-violet ">
                                            <div class="mega-title"><img src="img/gallery/icons/light.png" alt="" style="float: left; padding-right: 15px;"/>Fantastic Four</div>
                                            <div class="mega-date">Lorem ipsum dolor sit</div>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons ">
                                            <a class="fancybox" rel="group" href="img/gallery/image5.jpg" title="Awesome Creativity"><div class="mega-view mega-violet"></div></a>
                                        </div>

                                    </div>

                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-two cat-all"  id="mega-entry-6" data-src="img/gallery/image6.jpg" data-width="580" data-height="435">

                                        <div class="mega-covercaption mega-square-bottom mega-landscape-left mega-portrait-bottom mega-green ">
                                            <div class="mega-title"><img src="img/gallery/icons/nike.png" alt="" style="float: left; padding-right: 15px;"/>Rainy Day</div>
                                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat....</p>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-green"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image6.jpg" title="Be Good "><div class="mega-view mega-green"></div></a>
                                        </div>

                                    </div>



                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-three cat-all"  id="mega-entry-7" data-src="img/gallery/image7.jpg" data-width="780" data-height="385">

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-green"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image7.jpg"><div class="mega-view mega-green"></div></a>
                                        </div>

                                    </div>

                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-four cat-all"  id="mega-entry-8" data-src="img/gallery/image8.jpg" data-width="780" data-height="525">

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-orange"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image8.jpg"><div class="mega-view mega-orange"></div></a>
                                        </div>

                                    </div>

                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-two cat-all"  id="mega-entry-9" data-src="img/gallery/image9.jpg" data-width="780" data-height="585">

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-black"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image9.jpg"><div class="mega-view mega-black"></div></a>
                                        </div>

                                    </div>


                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-two cat-all"  id="mega-entry-11" data-src="img/gallery/image11.jpg" data-width="780" data-height="565">

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-black"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image11.jpg"><div class="mega-view mega-black"></div></a>
                                        </div>

                                    </div>

                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-three cat-all"  id="mega-entry-12" data-src="img/gallery/image12.jpg" data-width="780" data-height="525">

                                        <div class="mega-covercaption mega-square-bottom mega-landscape-bottom mega-portrait-bottom mega-turquoise ">
                                            <div class="mega-title">Metro Style</div>
                                            <div class="mega-date">Just one thing thats possible</div>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-turquoise"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image12.jpg" title="Lorem ipsum dloe"><div class="mega-view mega-turquoise"></div></a>
                                        </div>

                                    </div>


                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-one cat-all"  id="mega-entry-10" data-src="img/gallery/image10.jpg" data-width="780" data-height="585">

                                        <div class="mega-covercaption mega-square-right mega-landscape-right mega-portrait-bottom mega-blue ">
                                            <div class="mega-title">Get Back to Work</div>
                                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr...
                                                <img src="img/gallery/icons/runner.png" alt="" style="padding-top: 15px;"/>
                                            </p>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-blue"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image10.jpg" title="Get A Move On"><div class="mega-view mega-blue"></div></a>
                                        </div>

                                    </div>

                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-four cat-all"  id="mega-entry-13" data-src="img/gallery/image14.jpg" data-width="780" data-height="585">

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-black"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image14.jpg"><div class="mega-view mega-black"></div></a>
                                        </div>

                                    </div>

                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-one cat-all"  id="mega-entry-14" data-src="img/gallery/image16.jpg" data-width="780" data-height="585">

                                        <div class="mega-covercaption mega-square-bottom mega-landscape-left mega-portrait-bottom mega-red">
                                            <div class="mega-title">Summer Wine</div>
                                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua...</p>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-orange"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image16.jpg" title="Good Morning"><div class="mega-view mega-orange"></div></a>
                                        </div>

                                    </div>


                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-two cat-all"  id="mega-entry-15" data-src="img/gallery/image13.jpg" data-width="780" data-height="585">

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-orange"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image13.jpg"><div class="mega-view mega-orange"></div></a>
                                        </div>

                                    </div>

                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-one cat-all"  id="mega-entry-25" data-src="img/gallery/image15.jpg" data-width="780" data-height="585">

                                        <div class="mega-covercaption mega-square-top mega-landscape-left mega-portrait-top mega-violet ">
                                            <div class="mega-title"><img src="img/gallery/icons/mobile.png" alt="" style="float: left; padding-right: 15px;"/>Hi There.</div>
                                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros...</p>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-violet"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image15.jpg" title="Mobile Optimized"><div class="mega-view mega-violet"></div></a>
                                        </div>

                                    </div>

                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-two cat-all"  id="mega-entry-26" data-src="img/gallery/image18.jpg" data-width="780" data-height="585">

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-blue"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image18.jpg"><div class="mega-view mega-blue"></div></a>
                                        </div>

                                    </div>

                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-three cat-all"  id="mega-entry-27" data-src="img/gallery/image17.jpg" data-width="780" data-height="585">

                                        <div class="mega-covercaption mega-square-top mega-landscape-left mega-portrait-top mega-green">
                                            <div class="mega-title"><img src="img/gallery/icons/leaf.png" alt="" style="float: left; padding-right: 15px;"/>Enjoy Youseft !</div>
                                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros...</p>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-green"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image17.jpg" title="Good Day"><div class="mega-view mega-green"></div></a>
                                        </div>

                                    </div>

                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-one cat-all" id="mega-entry-28" data-src="img/gallery/image1.jpg" data-width="780" data-height="585" data-lowsize="">

                                            <div class="mega-covercaption mega-square-right mega-landscape-right mega-portrait-bottom mega-red">
                                                <!-- The Content Part with Hidden Overflow Container -->

                                                <div class="mega-title"><img src="img/gallery/icons/grid.png" alt="" style="float: left; padding-right: 15px;"/>Lorem ipsum dolor set ament</div>
                                                <div class="mega-date">Lorem ipsum dolor sit</div>
                                                <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua...<br/><br/><a href="#">Read the whole story</a></p>

                                            </div>

                                            <!-- The Link Buttons -->
                                            <div class="mega-coverbuttons mega-square-top mega-landscape-right mega-portrait-bottom">
                                                <div class="mega-link mega-red"></div>
                                                <a class="fancybox" rel="group" href="img/gallery/image1.jpg" title="Might is right"><div class="mega-view mega-red"></div></a>
                                            </div>

                                        </div>


                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-two cat-all"  id="mega-entry-29"  data-src="img/gallery/image2.jpg" data-width="780" data-height="585" data-lowsize="">

                                            <div class="mega-covercaption mega-square-bottom mega-landscape-left mega-portrait-bottom mega-orange mega-white ">

                                                <div class="mega-title">Sumon Mosa</div>
                                                <div class="mega-date">dolro ispum imit</div>
                                                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua...</p>
                                            </div>

                                            <!-- The Link Buttons -->
                                            <div class="mega-coverbuttons">
                                                <div class="mega-link mega-orange"></div>
                                                <a class="fancybox" rel="group" href="img/gallery/image2.jpg" title="Might is right"><div class="mega-view mega-orange"></div></a>
                                            </div>

                                        </div>



                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-four cat-all"  id="mega-entry-3" data-src="img/gallery/image3.jpg" data-width="780" data-height="585">

                                            <div class="mega-covercaption mega-square-top mega-landscape-bottom mega-portrait-bottom mega-turquoise ">
                                                <div class="mega-title"><img src="img/gallery/icons/flexible.png" alt="" style="float: left; padding-right: 15px;"/>Flexibility</div>
                                                <div class="mega-date">Never seen before</div>
                                            </div>

                                            <!-- The Link Buttons -->
                                            <div class="mega-coverbuttons">
                                                <div class="mega-link mega-turquoise"></div>
                                                <a class="fancybox" rel="group" href="img/gallery/image3.jpg" title="Be Happy"><div class="mega-view mega-turquoise"></div></a>
                                            </div>

                                        </div>



                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-three cat-all"  id="mega-entry-4" data-src="img/gallery/image4.jpg" data-width="780" data-height="585">

                                        <div class="mega-covercaption mega-square-bottom mega-landscape-bottom mega-portrait-bottom mega-black ">
                                            <div class="mega-title">Hi There !</div>
                                            <div class="mega-date">And so should you</div>
                                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt...</p>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-black"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image4.jpg" title="Do the Best"><div class="mega-view mega-black"></div></a>
                                        </div>

                                    </div>

                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-two cat-all"  id="mega-entry-5" data-src="img/gallery/image5.jpg" data-width="780" data-height="585">

                                        <div class="mega-covercaption mega-square-bottom mega-landscape-right mega-portrait-bottom mega-violet ">
                                            <div class="mega-title"><img src="img/gallery/icons/light.png" alt="" style="float: left; padding-right: 15px;"/>Creative Ideas</div>
                                            <div class="mega-date">Good for Nothing</div>
                                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua...</p>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-violet"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image5.jpg" title="Awesome Creativity"><div class="mega-view mega-violet"></div></a>
                                        </div>

                                    </div>


                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-one cat-all"  id="mega-entry-6" data-src="img/gallery/image6.jpg" data-width="780" data-height="585">

                                        <div class="mega-covercaption mega-square-bottom mega-landscape-left mega-portrait-bottom mega-green ">
                                            <div class="mega-title"><img src="img/gallery/icons/nike.png" alt="" style="float: left; padding-right: 15px;"/>Do the Best</div>
                                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi....</p>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-green"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image6.jpg" title="Be Good "><div class="mega-view mega-green"></div></a>
                                        </div>

                                    </div>


                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-four cat-all"  id="mega-entry-7" data-src="img/gallery/image7.jpg" data-width="780" data-height="585">

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-green"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image7.jpg"><div class="mega-view mega-green"></div></a>
                                        </div>

                                    </div>


                                    <div class="mega-entry cat-three cat-all"  id="mega-entry-8" data-src="img/gallery/image8.jpg" data-width="780" data-height="585">

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-orange"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image8.jpg"><div class="mega-view mega-orange"></div></a>
                                        </div>

                                    </div>


                                    <!-- A GALLERY ENTRY -->
                                    <div class="mega-entry cat-one cat-all"  id="mega-entry-9" data-src="img/gallery/image9.jpg" data-width="780" data-height="585">

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-black"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image9.jpg"><div class="mega-view mega-black"></div></a>
                                        </div>

                                    </div>


                                    <div class="mega-entry cat-four cat-all"  id="mega-entry-11" data-src="img/gallery/image11.jpg" data-width="780" data-height="585">

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-black"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image11.jpg"><div class="mega-view mega-black"></div></a>
                                        </div>

                                    </div>


                                  <!-- A GALLERY ENTRY -->
                                   <div class="mega-entry cat-two cat-all"  id="mega-entry-12" data-src="img/gallery/image12.jpg" data-width="780" data-height="585">

                                        <div class="mega-covercaption mega-square-bottom mega-landscape-bottom mega-portrait-bottom mega-turquoise ">
                                            <div class="mega-title">Metro Style</div>
                                            <div class="mega-date">As you so so you rep</div>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-turquoise"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image12.jpg" title="Lorem ipsum dloe"><div class="mega-view mega-turquoise"></div></a>
                                        </div>

                                    </div>


                                   <!-- A GALLERY ENTRY -->
                                   <div class="mega-entry cat-four cat-all"  id="mega-entry-10" data-src="img/gallery/image10.jpg" data-width="780" data-height="585">

                                        <div class="mega-covercaption mega-square-right mega-landscape-right mega-portrait-bottom mega-blue ">
                                            <div class="mega-title">Out or Order</div>
                                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr...
                                                <img src="img/gallery/icons/runner.png" alt="" style="padding-top: 15px;"/>
                                            </p>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-blue"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image10.jpg" title="Get A Move On"><div class="mega-view mega-blue"></div></a>
                                        </div>

                                    </div>


                                   <!-- A GALLERY ENTRY -->
                                   <div class="mega-entry cat-one cat-all"  id="mega-entry-13" data-src="img/gallery/image14.jpg" data-width="780" data-height="585">

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-black"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image14.jpg"><div class="mega-view mega-black"></div></a>
                                        </div>

                                    </div>


                                   <!-- A GALLERY ENTRY -->
                                   <div class="mega-entry cat-two cat-all"  id="mega-entry-14" data-src="img/gallery/image16.jpg" data-width="780" data-height="585">

                                        <div class="mega-covercaption mega-square-bottom mega-landscape-left mega-portrait-bottom mega-red">
                                            <div class="mega-title">Might is Right</div>
                                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua...</p>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-orange"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image16.jpg" title="Good Morning"><div class="mega-view mega-orange"></div></a>
                                        </div>

                                    </div>


                                   <!-- A GALLERY ENTRY -->
                                   <div class="mega-entry cat-one cat-all"  id="mega-entry-15" data-src="img/gallery/image13.jpg" data-width="780" data-height="585">

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-orange"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image13.jpg"><div class="mega-view mega-orange"></div></a>
                                        </div>

                                    </div>


                                   <!-- A GALLERY ENTRY -->
                                   <div class="mega-entry cat-two cat-all"  id="mega-entry-25" data-src="img/gallery/image15.jpg" data-width="780" data-height="585">

                                        <div class="mega-covercaption mega-square-bottom mega-landscape-bottom mega-portrait-top mega-violet ">
                                            <div class="mega-title"><img src="img/gallery/icons/mobile.png" alt="" style="float: left; padding-right: 15px;"/>Be Honest</div>
                                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros...</p>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-violet"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image15.jpg" title="Mobile Optimized"><div class="mega-view mega-violet"></div></a>
                                        </div>

                                    </div>


                                   <!-- A GALLERY ENTRY -->
                                   <div class="mega-entry cat-one cat-all"  id="mega-entry-26" data-src="img/gallery/image18.jpg" data-width="780" data-height="585">

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-blue"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image18.jpg"><div class="mega-view mega-blue"></div></a>
                                        </div>

                                    </div>


                                   <!-- A GALLERY ENTRY -->
                                   <div class="mega-entry cat-four cat-all"  id="mega-entry-27" data-src="img/gallery/image17.jpg" data-width="780" data-height="585">

                                        <div class="mega-covercaption mega-square-top mega-landscape-left mega-portrait-top mega-green ">
                                            <div class="mega-title"><img src="img/gallery/icons/leaf.png" alt="" style="float: left; padding-right: 15px;"/>Hi Boss !</div>
                                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros...</p>
                                        </div>

                                        <!-- The Link Buttons -->
                                        <div class="mega-coverbuttons">
                                            <div class="mega-link mega-green"></div>
                                            <a class="fancybox" rel="group" href="img/gallery/image17.jpg" title="Good Day"><div class="mega-view mega-green"></div></a>
                                        </div>

                                    </div>

                                </div>
                                </div>
                            </div>
                        </div>';
        
    	/*$html = '<div class="file-gallery-con simple-con"><ul class="file-gallery clearfix">';
    	if(!empty($array)) {
            reset($array);
            foreach ($array as $indice=>&$valor) {
                $link = '<a class="lajax" data-acao="" href="'.URL_PATH.'usuario_veiculo/Listar/Popup_Agendar_veiculo/'.$valor['id'].'/'.date('Y-m-d', strtotime("+1 days",strtotime(APP_DATA))).'/'.date('Y-m-d', strtotime("+6 days",strtotime(APP_DATA))).'/'.$valor['marca'].' '.$valor['modelo'].' '.$valor['cc'].' cc Ano de '.$valor['ano'].'/">';
                $html .= '<li>'.
                    $link.'<img src="'.ARQ_URL.'usuario_veiculo/'.$valor['id'].'.'.$valor['foto'].'" alt="file" width="50" height="50" /></a><span>'.$link.$valor['marca'].' '.$valor['modelo'].'<br>'.$valor['cc'].' cc <br>Ano de '.$valor['ano'].'</a></span>'.
                    '<div>'.
                        $link.'<img src="'.WEB_URL.'img/turboadmin/icon_view.png" alt="Visualizar" class="explicar-titulo" title="Visualizar" /></a>'.
                    '</div>'.
                '</li>';
            }
    	}
        $html .= '</ul></div>';*/
        /*$js1 = Array(WEB_URL.'assets/metr-folio/js/jquery.metro-gal.plugins.min');
        $js2 = Array(WEB_URL.'assets/metr-folio/js/jquery.metro-gal.megafoliopro');
        $Visual->Json_IncluiTipo('Javascript',$js1);
        $Visual->Json_IncluiTipo('Javascript',$js2);*/
        $Visual->Javascript_Executar('var api=jQuery(\'.metro-gal-container\').megafoliopro(
                   {
                       filterChangeAnimation:"pagebottom",			// fade, rotate, scale, rotatescale, pagetop, pagebottom,pagemiddle
                       filterChangeSpeed:400,					// Speed of Transition
                       filterChangeRotate:99,					// If you ue scalerotate or rotate you can set the rotation (99 = random !!)
                       filterChangeScale:0.6,					// Scale Animation Endparameter
                       delay:20,
                       defaultWidth:980,
                       paddingHorizontal:10,
                       paddingVertical:10,
                       layoutarray:[9,11,5,3,7,12,4,6,13]		// Defines the Layout Types which can be used in the Gallery. 2-9 or "random". You can define more than one, like {5,2,6,4} where the first items will be orderd in layout 5, the next comming items in layout 2, the next comming items in layout 6 etc... You can use also simple {9} then all item ordered in Layout 9 type.
                   });

           // FANCY BOX ( LIVE BOX) WITH MEDIA SUPPORT
           jQuery(".fancybox").fancybox();

           // THE FILTER FUNCTION
           jQuery(\'.filter\').click(function() {
               jQuery(\'.filter\').each(function() { jQuery(this).removeClass("selected")});
               api.megafilter(jQuery(this).data(\'category\'));
               jQuery(this).addClass("selected");
           });');
    	return $html;
    }
}
?>