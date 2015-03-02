<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">  <xsl:output method="html"/>

  <xsl:template match="/">

    <table class="table">
      <thead>
	<tr>
	  <xsl:for-each select="root/head/header">
	    <th>
	      <xsl:value-of select="."/>
	    </th>
	  </xsl:for-each>
	</tr>
      </thead>
      <tbody>
	<xsl:for-each select="root/body/row">
	  <tr>
	    <xsl:for-each select="cell">
	      <td>
		<xsl:value-of select="."/>
	      </td>
	    </xsl:for-each>
	  </tr>
	</xsl:for-each>
      </tbody>
    </table>

  </xsl:template>
</xsl:stylesheet>
