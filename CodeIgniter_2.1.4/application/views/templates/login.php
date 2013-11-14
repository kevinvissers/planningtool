<div id="dialog" title="Aanmelden">
    <!--<p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>-->
    <form method="post">
        <table>
            <tr>
                <td><label for="gebruiker">Gebruikersnaam</label></td>
                <td><input type="text" name="gebruiker" id="gebruiker" required /></td>
            </tr>
            <tr>
                <td><label for="wachtw">Wachtwoord</label></td>
                <td><input type="password" name="wachtw" id="wachtw" required /></td>
            </tr>
            <tr>
                <td><label for="domein">Aanmelden op</label></td>
                <td>
                    <select name="domein" id="domein">
                        <option selected="selected" value="kalender">Kalender</option>
                        <option value="sitebeheer">Sitebeheer</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><input type="submit" name="aanmelden" value="Aanmelden" /></td>
                <td><input type="button" name="cancel" value="Cancel" id="cancel" onclick="window.close();" /></td>
            </tr>
        </table>
    </form>
</div>
