<!-- Main Page Content and Sidebar -->

	<div class="row">

            <!-- Main Blog Content -->
            <div class="large-8 columns" role="content">
                <h3>Kalender</h3>
                <div><?php echo $kalender; ?></div> 
            </div>
            <!-- End Main Content -->

            <!-- Sidebar -->
            <aside class="large-4 columns">
              <div class="panel">
                <h5>Afspraken</h5>
                <ul class="side-nav">
                    <?php echo $afspraak; ?>
                </ul>
                <!--<a href="#">Read More &rarr;</a>-->
              </div>
            </aside>
            <aside class="large-4 columns">
              <div class="panel">
                <h5>Beheren</h5>
                <ul class="side-nav">
                    <li><a href="<?php echo base_url(); ?>index.php/afspraken/toevoegen" class="fi-plus size-14" >&nbsp;&nbsp;Nieuwe Afspraak</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/klanten/toevoegen" class="fi-plus size-14" >&nbsp;&nbsp;Nieuwe Klant</a></li>
                </ul>
                <!--<a href="#">Read More &rarr;</a>-->
              </div>
            </aside>
            <!-- End Sidebar -->
	</div>

	<!-- End Main Content and Sidebar -->

