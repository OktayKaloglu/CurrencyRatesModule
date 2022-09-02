<html>
<head>
    <title>Main Page</title>
</head>

<body>
<form action = "/parityfill" method = "post">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <table>

            <td colspan = '2'>
                <input type = 'submit' value = "Fill Parity"/>
            </td>
        </tr>
    </table>
</form>
<form action = "/showparity" method = "post">
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
<form action = "/showrates" method = "post">
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
