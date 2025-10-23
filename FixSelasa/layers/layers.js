ol.proj.proj4.register(proj4);
//ol.proj.get("ESRI:102100").setExtent([13048688.499094, -72259.331885, 13054845.621220, -68994.523356]);
var wms_layers = [];


        var lyr_GoogleSatellite_0 = new ol.layer.Tile({
            'title': 'Google Satellite',
            'opacity': 1.000000,
            
            
            source: new ol.source.XYZ({
            attributions: ' &nbsp &middot; <a href="https://www.google.at/permissions/geoguidelines/attr-guide.html">Map data ©2015 Google</a>',
                url: 'https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}'
            })
        });
var format_Sumberdaya_1 = new ol.format.GeoJSON();
var features_Sumberdaya_1 = format_Sumberdaya_1.readFeatures(json_Sumberdaya_1, 
            {dataProjection: 'EPSG:4326', featureProjection: 'ESRI:102100'});
var jsonSource_Sumberdaya_1 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Sumberdaya_1.addFeatures(features_Sumberdaya_1);
var lyr_Sumberdaya_1 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_Sumberdaya_1, 
                style: style_Sumberdaya_1,
                popuplayertitle: 'Sumberdaya',
                interactive: true,
    title: 'Sumberdaya<br />\
    <img src="styles/legend/Sumberdaya_1_0.png" /> Danau<br />\
    <img src="styles/legend/Sumberdaya_1_1.png" /> Pemukiman<br />\
    <img src="styles/legend/Sumberdaya_1_2.png" /> Sungai<br />\
    <img src="styles/legend/Sumberdaya_1_3.png" /> Tambang<br />\
    <img src="styles/legend/Sumberdaya_1_4.png" /> Tanah Lapang<br />\
    <img src="styles/legend/Sumberdaya_1_5.png" /> Telaga Biru<br />\
    <img src="styles/legend/Sumberdaya_1_6.png" /> Hutan<br />' });
var format_Rt_2 = new ol.format.GeoJSON();
var features_Rt_2 = format_Rt_2.readFeatures(json_Rt_2, 
            {dataProjection: 'EPSG:4326', featureProjection: 'ESRI:102100'});
var jsonSource_Rt_2 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Rt_2.addFeatures(features_Rt_2);
var lyr_Rt_2 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_Rt_2, 
                style: style_Rt_2,
                popuplayertitle: 'Rt.',
                interactive: true,
    title: 'Rt.<br />\
    <img src="styles/legend/Rt_2_0.png" /> 001<br />\
    <img src="styles/legend/Rt_2_1.png" /> 002<br />\
    <img src="styles/legend/Rt_2_2.png" /> 003<br />\
    <img src="styles/legend/Rt_2_3.png" /> 004<br />\
    <img src="styles/legend/Rt_2_4.png" /> 005<br />\
    <img src="styles/legend/Rt_2_5.png" /> 006<br />\
    <img src="styles/legend/Rt_2_6.png" /> 007<br />\
    <img src="styles/legend/Rt_2_7.png" /> 008<br />\
    <img src="styles/legend/Rt_2_8.png" /> 009<br />\
    <img src="styles/legend/Rt_2_9.png" /> 010<br />' });
var format_LahanPertanian_3 = new ol.format.GeoJSON();
var features_LahanPertanian_3 = format_LahanPertanian_3.readFeatures(json_LahanPertanian_3, 
            {dataProjection: 'EPSG:4326', featureProjection: 'ESRI:102100'});
var jsonSource_LahanPertanian_3 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_LahanPertanian_3.addFeatures(features_LahanPertanian_3);
var lyr_LahanPertanian_3 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_LahanPertanian_3, 
                style: style_LahanPertanian_3,
                popuplayertitle: 'Lahan Pertanian',
                interactive: true,
    title: 'Lahan Pertanian<br />\
    <img src="styles/legend/LahanPertanian_3_0.png" /> Perkebunan<br />' });
var format_Perikanan_4 = new ol.format.GeoJSON();
var features_Perikanan_4 = format_Perikanan_4.readFeatures(json_Perikanan_4, 
            {dataProjection: 'EPSG:4326', featureProjection: 'ESRI:102100'});
var jsonSource_Perikanan_4 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Perikanan_4.addFeatures(features_Perikanan_4);
var lyr_Perikanan_4 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_Perikanan_4, 
                style: style_Perikanan_4,
                popuplayertitle: 'Perikanan',
                interactive: true,
                title: '<img src="styles/legend/Perikanan_4.png" /> Perikanan'
            });
var format_Wisata_5 = new ol.format.GeoJSON();
var features_Wisata_5 = format_Wisata_5.readFeatures(json_Wisata_5, 
            {dataProjection: 'EPSG:4326', featureProjection: 'ESRI:102100'});
var jsonSource_Wisata_5 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_Wisata_5.addFeatures(features_Wisata_5);
var lyr_Wisata_5 = new ol.layer.Vector({
                declutter: false,
                source:jsonSource_Wisata_5, 
                style: style_Wisata_5,
                popuplayertitle: 'Wisata',
                interactive: true,
    title: 'Wisata<br />\
    <img src="styles/legend/Wisata_5_0.png" /> Danau<br />\
    <img src="styles/legend/Wisata_5_1.png" /> Sumur Minyak<br />\
    <img src="styles/legend/Wisata_5_2.png" /> Sungai<br />\
    <img src="styles/legend/Wisata_5_3.png" /> Taman Bunga Firsa<br />' });

lyr_GoogleSatellite_0.setVisible(true);lyr_Sumberdaya_1.setVisible(false);lyr_Rt_2.setVisible(true);lyr_LahanPertanian_3.setVisible(true);lyr_Perikanan_4.setVisible(true);lyr_Wisata_5.setVisible(true);
var layersList = [lyr_GoogleSatellite_0,lyr_Sumberdaya_1,lyr_Rt_2,lyr_LahanPertanian_3,lyr_Perikanan_4,lyr_Wisata_5];
lyr_Sumberdaya_1.set('fieldAliases', {'id': 'id', 'Lokasi': 'Lokasi', 'Gambar': 'Gambar', 'Pada': 'Pada', });
lyr_Rt_2.set('fieldAliases', {'id': 'id', 'Kelurahan': 'Kelurahan', 'Rt': 'Rt', 'GambarRt': 'GambarRt', });
lyr_LahanPertanian_3.set('fieldAliases', {'id': 'id', 'Nama': 'Nama', 'Keterangan': 'Keterangan', 'Pada': 'Pada', });
lyr_Perikanan_4.set('fieldAliases', {'id': 'id', 'Budidaya': 'Budidaya', 'Pada': 'Pada', });
lyr_Wisata_5.set('fieldAliases', {'id': 'id', 'Nama': 'Nama', 'Gambar': 'Gambar', });
lyr_Sumberdaya_1.set('fieldImages', {'id': 'TextEdit', 'Lokasi': 'TextEdit', 'Gambar': 'ExternalResource', 'Pada': '', });
lyr_Rt_2.set('fieldImages', {'id': 'TextEdit', 'Kelurahan': 'TextEdit', 'Rt': 'TextEdit', 'GambarRt': 'ExternalResource', });
lyr_LahanPertanian_3.set('fieldImages', {'id': 'TextEdit', 'Nama': 'TextEdit', 'Keterangan': 'TextEdit', 'Pada': '', });
lyr_Perikanan_4.set('fieldImages', {'id': 'TextEdit', 'Budidaya': '', 'Pada': '', });
lyr_Wisata_5.set('fieldImages', {'id': 'TextEdit', 'Nama': 'TextEdit', 'Gambar': 'ExternalResource', });
lyr_Sumberdaya_1.set('fieldLabels', {'id': 'hidden field', 'Lokasi': 'no label', 'Gambar': 'no label', 'Pada': 'inline label - always visible', });
lyr_Rt_2.set('fieldLabels', {'id': 'hidden field', 'Kelurahan': 'inline label - always visible', 'Rt': 'inline label - always visible', 'GambarRt': 'no label', });
lyr_LahanPertanian_3.set('fieldLabels', {'id': 'hidden field', 'Nama': 'no label', 'Keterangan': 'no label', 'Pada': 'inline label - always visible', });
lyr_Perikanan_4.set('fieldLabels', {'id': 'hidden field', 'Budidaya': 'no label', 'Pada': 'no label', });
lyr_Wisata_5.set('fieldLabels', {'id': 'hidden field', 'Nama': 'no label', 'Gambar': 'no label', });
lyr_Wisata_5.on('precompose', function(evt) {
    evt.context.globalCompositeOperation = 'normal';
});