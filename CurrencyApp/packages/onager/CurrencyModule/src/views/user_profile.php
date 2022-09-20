<html>
<head>
    <title>User Profile</title>
</head>

<form action = "/user/token" method = "post">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <table>

        <td colspan = '2'>
            <input type = 'submit' value = "Get API Token"/>
        </td>
        </tr>
    </table>
    <input type = "hidden" name = "/newToken" value = "<?php echo csrf_token(); ?>">
    <table>

        <td colspan = '2'>
            <input type = 'submit' value = "Refresh The Token"/>
        </td>
        </tr>
    </table>
</form>
'<a href = "/main">Click Here</a> to go main page.';

