
echo $sqlstr="SELECT * FROM (select * from personalinfo
inner join tblcountries on tblcountries.countryid=personalinfo.nationality
inner join tbllga on tbllga.lgaid=personalinfo.lga
inner join ranks on ranks.rankID=personalinfo.rank
inner join tblunit on tblunit.unitid=personalinfo.unit
WHERE ranks.ranktype".$scadre.")as cadre
CROSS JOIN (select * from personalinfo
inner join tblcountries on tblcountries.countryid=personalinfo.nationality
inner join tbllga on tbllga.lgaid=personalinfo.lga
inner join ranks on ranks.rankID=personalinfo.rank
inner join tblunit on tblunit.unitid=personalinfo.unit
WHERE ranks.rankID".$srank.")as rank
CROSS JOIN (select * from personalinfo
inner join tblcountries on tblcountries.countryid=personalinfo.nationality
inner join tbllga on tbllga.lgaid=personalinfo.lga
inner join ranks on ranks.rankID=personalinfo.rank
inner join tblunit on tblunit.unitid=personalinfo.unit
WHERE personalinfo.unit".$sunit.")as unit";
}else
$sqlstr="select * from personalinfo
inner join tblcountries on tblcountries.countryid=personalinfo.nationality
inner join tblstate on tblstate.stateid=personalinfo.state
inner join tbllga on tbllga.lgaid=personalinfo.lga
inner join ranks on ranks.rankID=personalinfo.rank
inner join tblunit on tblunit.unitid=personalinfo.unit";
