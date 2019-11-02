<?php
include_once "include/DB.php";
class SimpleXMLElement_Plus extends SimpleXMLElement {

    public function addProcessingInstruction( $name, $value )
    {
        // Create a DomElement from this simpleXML object
        $dom_sxe = dom_import_simplexml($this);

        // Create a handle to the owner doc of this xml
        $dom_parent = $dom_sxe->ownerDocument;

        // Find the topmost element of the domDocument
        $xpath = new DOMXPath($dom_parent);
        $first_element = $xpath->evaluate('/*[1]')->item(0);

        // Add the processing instruction before the topmost element
        $pi = $dom_parent->createProcessingInstruction($name, $value);
        $dom_parent->insertBefore($pi, $first_element);
    }
}
if(!isset($_COOKIE['details'])){
    header("Location: index.php");
}else{
    $details = explode("|", base64_decode($_COOKIE['details']));

    $card = $details[0];

    $result = $conn->query("SELECT t.timestamp as 'timestamp', t.comment as comment, t.amount as amount,
                                    a.location as location
                                    FROM transactions t, atms a WHERE t.card_no=$card and t.atm_no=a.atm_no ORDER BY timestamp DESC LIMIT 10");
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $xml = new SimpleXMLElement_Plus('<transactions></transactions>');
    $xml->addProcessingInstruction('xml-stylesheet', 'type="text/xsl" href="css/statement.xsl"');

// $xml->addAttribute('motto','Learning is all it matters!!');
    for($i=0;$i<count($rows);$i++)
    {
        $novel = $xml->addChild('transaction');
        $novel->addChild('timestamp',$rows[$i]['timestamp']);
        $novel->addChild('comment',$rows[$i]['comment']);
        $novel->addChild('location',$rows[$i]['location']);

        if($rows[$i]['amount'] > 0)
            $novel->addChild('type','Cr.');
        else
            $novel->addChild('type', "Dr.");

        $novel->addChild('amount',abs($rows[$i]['amount']));

    }
    Header('Content-type: text/xml');
    echo $xml->asXML();
}