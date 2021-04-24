var iframeHead = $('#preview-iframe').contents().find('head')[0];
var iframeWin = document.getElementById('preview-iframe').contentWindow;
var loadjs = iframeWin.loadjs;

loadjs('assets/css/preview-core.min.css', { target: iframeWin });

// Prism code highlighter
loadjs(['lib/prism/prism.min.css', 'lib/prism/prism.min.js'], { target: iframeWin });
