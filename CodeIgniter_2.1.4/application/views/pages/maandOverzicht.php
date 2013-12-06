<!-- Main Page Content and Sidebar -->

	<div class="row">

            <!-- Main Blog Content -->
            <div class="large-6 columns" role="content">
                <div class="row">
                    <div class="large-12 columns">
                        <h3>Kalender</h3>
                        <div><?php echo $kalender; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <div class="panel">
                        <h5>Afspraken</h5>
                        <ul class="side-nav">
                            <?php echo $afspraak; ?>
                        </ul>                        
                      </div>
                    </div>
                </div>
            </div>
            <!-- End Main Content -->

            <!-- Sidebar -->            
            <aside class="large-6 columns">
                <h3>Afspraak</h3>
              <div class="panel">
                <ul class="side-nav">
                    <?php echo $eigenschappen ?>
                </ul>
                <!--<a href="#">Read More &rarr;</a>-->
              </div>
            </aside>
            <!-- End Sidebar -->
	</div>

	<!-- End Main Content and Sidebar -->

