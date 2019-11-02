<?xml version="1.0"?>

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="/">
        <html>
            <head>
                <style>

                    body{
                    margin:0;
                    padding: 0;
                    font-family: hacked;
                    src: url("../fonts/HACKED.ttf");
                    color: white;
                    background-color:  #1f242e;
                    background-image: url(../img/lg.png);
                    background-repeat: no-repeat;
                    }

                    .box{
                    width: 500px;
                    padding: 40px;
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background: #191919;
                    text-align: center;
                    box-shadow:  5px 5px 5px 5px black;
                    border-radius: 24px;
                    }
                </style>
            </head>
            <body>
                <div class='box'>
                <h1> Account Statement </h1>
                <h2>Transactions</h2>
                <table border="2" align="center" cellpadding="5">
                    <tr bgcolor="#9acd32">
                        <th>Date/Time</th>
                        <th>Comment</th>
                        <th>Location</th>
                        <th>Cr./Dr.</th>
                        <th>Amount</th>
                    </tr>
                    <xsl:for-each select="transactions/transaction">
                        <tr>
                            <td><xsl:value-of select="timestamp"/></td>
                            <td><xsl:value-of select="comment"/></td>
                            <td><xsl:value-of select="location"/></td>
                            <td><xsl:value-of select="type"/></td>
                            <td><xsl:value-of select="amount"/>/-</td>
                        </tr>
                    </xsl:for-each>
                </table>
                <input type="submit" value="HOME" onclick="location.href='index.php'"/>
                    <script>
                        setTimeout(function(){
                            location.href = 'index.php';
                        }, 15000);
                    </script>
                </div>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
