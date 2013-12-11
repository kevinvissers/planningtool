<div id="dialog" title="Aanmelden">
    <?php $attributes = array('class' => 'custom'); ?>
    <?php echo validation_errors(); ?>
    <?php echo form_open('verifylogin', $attributes); ?>
        <div class="row">
            <div class="large-12 columns">
                <label for="gebruiker">Gebruikersnaam</label>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <input type="email" size="20" id="username" name="username" required />
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <label for="wachtw">Wachtwoord</label>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <input type="password" size="20" id="password" name="password" required />
            </div>
        </div>
            <!--<tr>
                <td><a href="<?php //echo site_url() ?>/gebruiker/code">wachtwoord vergeten?</a></td>
            </tr>-->
            <!--<tr>
                <td><label for="domein">Aanmelden op</label></td>
                <td>
                    <select name="domein" id="domein">
                        <option selected="selected" value="kalender">Kalender</option>
                        <option value="sitebeheer">Sitebeheer</option>
                    </select>
                </td>
            </tr>-->
            <div class="row">
		<div class="large-6 columns">
                    <input type="submit" value="Aanmelden" name="frmLogOn" class="small button" />
                </div>
                <div class="large-6 columns">
                    <input type="button" name="cancel" value="Cancel" id="cancel" class="small button" onclick="window.close();" />
                </div>
            </div> 
    </form>
</div>
