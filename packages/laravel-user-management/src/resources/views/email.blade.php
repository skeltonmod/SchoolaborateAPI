<!-- Click here to verify your account:  -->
<!-- <a href="{{ $link = route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) }}">{{ $link }}</a> -->
<!-- <html>
    <img src="https://spekapp-bucket.s3.ap-southeast-2.amazonaws.com/public/dev/spek_logo.png">
</html> -->

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
    <!--[if mso]>
	<noscript>
		<xml>
			<o:OfficeDocumentSettings>
				<o:PixelsPerInch>96</o:PixelsPerInch>
			</o:OfficeDocumentSettings>
		</xml>
	</noscript>
	<![endif]-->
    <style>
        table,
        td,
        div,
        h1,
        p {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body style="margin:0;padding:0;">
    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
        <tr>
            <td align="center" style="padding:0; margin-top: 2em;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                    <tr>

                        <td align="center" style="padding:10px 0 10px 0;">
                            <h4>Welcome to Spek Technologies!</h4>
                            <img src="https://spekapp-bucket.s3.ap-southeast-2.amazonaws.com/public/dev/spek_gradient_logo.png" alt="" width="128" style="height:auto;display:block;" />
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:36px 30px 42px 30px;">
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                    <td style="padding:0 0 36px 0;color:#153643; text-align:center;">
                                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">We're so excited to have you on board.</p>
                                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Please click the following <a href="{{ 'https://'.strtolower($role).'.'.env('ROOT_URL'). '/login'. '?token=' . $user->verification_token}}">link</a> to activate your Spek User Account.</p>
                                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">We look forward to making things easier for you, so you can focus on doing deals!</p>

                                </tr>

                                <tr>

                                    <td align="center">
                                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif; text-align:center;">Best, <br> Andrea & Nikki</p>
                                        <img src="https://spekapp-bucket.s3.ap-southeast-2.amazonaws.com/public/dev/spek_gradient_logo_black.png" alt="" width="128" style="height:auto;display:block;" />
                                    </td>
                                </tr>

                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>