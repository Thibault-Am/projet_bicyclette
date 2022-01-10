<?xml version='1.0' encoding="UTF-8" ?>
 <xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
   <xsl:output method="text"/>

    <xsl:template match="/query">
      Latitude = <xsl:value-of select="lat"/>;
      Lontitude = <xsl:value-of select="lon"/>;
    </xsl:template>

</xsl:stylesheet>

