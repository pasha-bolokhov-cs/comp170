<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<!-- View module -->

<xsl:template match="/">
  <html>
  <body>
  <h1><xsl:value-of select="root/title"/></h1>
  <h2><xsl:value-of select="root/Input/title"/></h2>
  <form method = "post" action = "controller.php">
    <ul>
    <xsl:for-each select="root/Input/entry">
      <li><xsl:value-of select="name"/> = 
      <input type="text" name="input[]" value="{value}"/></li>
    </xsl:for-each>
    </ul>
    <input type = "submit"/>
  </form>

 <h2><xsl:value-of select="root/Output/title"/></h2>
  <ul>

<!--
Display knowing we have 2 entry name value pairs: -->

<!--
  <xsl:for-each select="root/Output/entry">
    <li><xsl:value-of select="name"/> = <xsl:value-of select="value"/></li>  
    <xsl:message> Hello there.</xsl:message>
  </xsl:for-each>
-->

<!--Alternatively display each entry in the above selected entry. This is an alternative way to display the
entries if we don't know how many there are or if we want to display a table.
-->

<xsl:for-each select="root/Output/entry">
<li>
  <xsl:for-each select="name">
    <xsl:value-of select="."/>
  </xsl:for-each> = 
  <xsl:for-each select="value">
    <xsl:value-of select="."/>
  </xsl:for-each>
</li>
</xsl:for-each>

  </ul>
  </body>
  </html>
</xsl:template>
</xsl:stylesheet>
