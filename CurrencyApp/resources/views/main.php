<html>
<head>
    <title>Main Page</title>
</head>

<body>
<form action = "/user" method = "get">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <table>

        <td colspan = '2'>
            <input type = 'submit' value = "User Profile"/>
        </td>
        </tr>
    </table>
</form>
<form action = "/test" method = "get">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <table>

        <td colspan = '2'>
            <input type = 'submit' value = "Test"/>
        </td>
        </tr>
    </table>
</form>
<form action = "/parityfill" method = "post">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <table>

            <td colspan = '2'>
                <input type = 'submit' value = "Fill Parity"/>
            </td>
        </tr>
    </table>
</form>
<form action = "/showparity" method = "get">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <table>

        <td colspan = '2'>
            <input type = 'submit' value = "Show Parity"/>
        </td>
        </tr>
    </table>
</form>
<form action = "/ratesfill" method = "post">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <table>

        <td colspan = '2'>
            <input type = 'submit' value = "Fill Rates"/>
        </td>
        </tr>
    </table>
</form>
<form action = "/showrates" method = "get">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <table>

        <td colspan = '2'>
            <input type = 'submit' value = "Show Rates"/>
        </td>
        </tr>
    </table>
</form>
</body>
</html>
