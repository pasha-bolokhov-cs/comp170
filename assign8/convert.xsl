<?xml version="1.0"?>
<!--
  Assignment 8
  Program name: convert.xsl
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: March 2, 2015
  Estimated Completion Time: 8 hr
  Actual Completion Time: 14 hr
  Description:
	The View part of the web-form MySQL database query
	Defines the stylesheet to transform the query result data
	from XML into an HTML table
  Invocation: via 'xml-stylesheet' tag only
  Requires: n/a
--> 
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html"/>

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
