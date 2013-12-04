<div id="dialog" title="Aanmelden">
    <!--<p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>-->
    <?php echo validation_errors(); ?>
    <?php echo form_open('verifylogin'); ?>
        <table>
            <tr>
                <td><label for="gebruiker">Gebruikersnaam</label></td>
                <td><input type="email" size="20" id="username" name="username" required /></td>
            </tr>
            <tr>
                <td><label for="wachtw">Wachtwoord</label></td>
                <td><input type="password" size="20" id="password" name="password" required /></td>
            </tr>
            <tr>
                <td><a href="<?php echo site_url() ?>/gebruiker/code">wachtwoord vergeten?</a></td>
            </tr>
            <!--<tr>
                <td><label for="domein">Aanmelden op</label></td>
                <td>
                    <select name="domein" id="domein">
                        <option selected="selected" value="kalender">Kalender</option>
                        <option value="sitebeheer">Sitebeheer</option>
                    </select>
                </td>
            </tr>-->
            <tr>
                <td><input type="submit" value="Aanmelden" name="frmLogOn" /></td>
                <td><input type="button" name="cancel" value="Cancel" id="cancel" onclick="window.close();" /></td>
            </tr>
        </table>
    </form>
</div>
