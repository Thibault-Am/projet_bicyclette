<?xml version='1.0' encoding="UTF-8" ?>
 <xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
   <xsl:output method="html"/>

   <xsl:template match="previsions">
      <html>
  <body>
          <xsl:apply-templates select="echeance"/>
        
    </body>
    </html>
    </xsl:template>


    <xsl:template match="echeance">
      <xsl:variable name='date' select="@timestamp" />
      <xsl:variable name='date_form' select="substring($date,0,11)"/>
     
      <!--<xsl:value-of select="substring($date,12,2)"/>-->
 
      <xsl:choose>
     
        <xsl:when test="substring($date,12,2)=16">
        <h2> Après midi <i>(<xsl:value-of select="substring($date,12,2)"/>H00)</i></h2>
        <xsl:apply-templates select="temperature"/>
        <xsl:apply-templates select="pluie"/>
        <xsl:apply-templates select="vent_moyen"/>
        </xsl:when>
        <xsl:when test="substring($date,12,2)=10">
       <h1><xsl:value-of select="substring($date,0,11)"/> </h1>
       <h2> Matin <i>(<xsl:value-of select="substring($date,12,2)"/>H00)</i></h2>
       <xsl:apply-templates select="temperature"/>
       <xsl:apply-templates select="pluie"/>
       <xsl:apply-templates select="vent_moyen"/>
        </xsl:when>
        <xsl:when test="substring($date,12,2)=19">
       
        <h2> Soir <i>(<xsl:value-of select="substring($date,12,2)"/>H00)</i></h2>
        <xsl:apply-templates select="temperature"/>
        <xsl:apply-templates select="pluie"/>
        <xsl:apply-templates select="vent_moyen"/>
        </xsl:when>
      </xsl:choose>
      
    </xsl:template>

    <xsl:template match="temperature">
      <div>Température: <xsl:value-of select='format-number(*[@val="sol"] - 273.15,"##.##")'/>°C</div>
    </xsl:template>
    <xsl:template match="pluie">
      <div>Pluie: <xsl:value-of select='format-number(. ,"##.##")'/> mm/h </div>
    </xsl:template>
    <xsl:template match="vent_moyen">
      <div>Vent: <xsl:value-of select='format-number(. ,"##.##")'/> km/h </div>
    </xsl:template>

</xsl:stylesheet>

