<?xml version='1.0' encoding="UTF-8" ?>
 <xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
   <xsl:output method="html"/>

   <xsl:template match="previsions">
      <table border='1'>
        <thead>
          
        </thead>
        <tbody>
        <tr>
          <xsl:apply-templates select="echeance"/>
          </tr>
                </tbody>
      </table>
  
    </xsl:template>


    <xsl:template match="echeance">
      
       <xsl:variable name='date' select="@timestamp" />
        <xsl:variable name='date_form' select="substring($date,0,11)"/>
     
      <!--   <xsl:value-of select="substring($date,12,2)"/>-->


      <xsl:choose>
     
        <xsl:when test="substring($date,12,2)=16">
        <td><b> Après midi <i>(<xsl:value-of select="substring($date,12,2)"/>H00) :</i></b>
        <xsl:apply-templates select="temperature"/>
        <xsl:apply-templates select="pluie"/>
        <xsl:apply-templates select="vent_moyen"/></td>
        </xsl:when>
        <xsl:when test="substring($date,12,2)=10">
      <tr><td colspan="3"><h3><xsl:value-of select="substring($date,0,11)"/></h3></td></tr>
      <td><b> Matin <i>(<xsl:value-of select="substring($date,12,2)"/>H00) :</i></b>
       <xsl:apply-templates select="temperature"/>
       <xsl:apply-templates select="pluie"/>
       <xsl:apply-templates select="vent_moyen"/></td>
        </xsl:when>
        <xsl:when test="substring($date,12,2)=19">
       
        <td><b> Soir <i>(<xsl:value-of select="substring($date,12,2)"/>H00) :</i></b>
        <xsl:apply-templates select="temperature"/>
        <xsl:apply-templates select="pluie"/>
        <xsl:apply-templates select="vent_moyen"/></td>
        </xsl:when>
      </xsl:choose>

      
      
    </xsl:template>

    <xsl:template match="temperature">
    <xsl:variable name='temperature' select='format-number(*[@val="sol"] - 273.15,"##.##")' />
      <div>Température: <xsl:value-of select='$temperature'/>°C</div>
      <xsl:choose>
        <xsl:when test="$temperature &lt; 5">
          <img src="img/flocon-de-neige.png" alt="fzeeagfa" width='20px'/>
        </xsl:when>
        <xsl:when test="$temperature &lt; 18 and $temperature &gt; 5 ">
          <img src="img/temperatures.png" alt="fzeeagfa" width='20px'/>
        </xsl:when>
        <xsl:when test="$temperature &gt; 18">
          <img src="img/temperature-chaude.png" alt="fzeeagfa" width='20px'/>
        </xsl:when>
      </xsl:choose>
    </xsl:template>
    <xsl:template match="pluie">
      <div>Pluie: <xsl:value-of select='format-number(. ,"##.##")'/> mm/h </div>
    </xsl:template>
    <xsl:template match="vent_moyen">
      <div>Vent: <xsl:value-of select='format-number(. ,"##.##")'/> km/h </div>
    </xsl:template>

</xsl:stylesheet>
