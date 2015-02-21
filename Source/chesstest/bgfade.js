var nlbFade_hextable = [ '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F' ]; // used for RGB to Hex and Hex to RGB conversions
var nlbFade_elemTable = new Array( ); // global array to keep track of faded elements
var nlbFade_t = new Array( ); // global array to keep track of fading timers
function NLBfadeBg( elementId, startBgColor, endBgColor, fadeTime )
{
	var timeBetweenSteps = Math.round( Math.max( fadeTime / 300, 30 ) );
	var nlbFade_elemTableId = nlbFade_elemTable.indexOf( elementId );
	if( nlbFade_elemTableId > -1 )
	{
		for( var i = 0; i < nlbFade_t[nlbFade_elemTableId].length; i++ )
			clearTimeout( nlbFade_t[nlbFade_elemTableId][i] );
	}
	else
	{
		nlbFade_elemTable.push( elementId );
		nlbFade_elemTableId = nlbFade_elemTable.indexOf( elementId );
	}
	var startBgColorRGB = hexToRGB( startBgColor );
	var endBgColorRGB = hexToRGB( endBgColor );
	var diffRGB = new Array( );
	for( var i = 0; i < 3; i++ )
		diffRGB[i] = endBgColorRGB[i] - startBgColorRGB[i];
	var steps = Math.ceil( fadeTime / timeBetweenSteps );
	var nlbFade_s = new Array( );
	for( var i = 1; i <= steps; i++ )
	{
		var changes = new Array( );
		for( var j = 0; j < diffRGB.length; j++ )
			changes[j] = startBgColorRGB[j] + Math.round( ( diffRGB[j] / steps ) * i );
		if( i == steps )
			nlbFade_s[i - 1] = setTimeout( 'document.getElementById("'+elementId+'").style.backgroundColor = "'+endBgColor+'";', timeBetweenSteps*(i-1) );
		else
			nlbFade_s[i - 1] = setTimeout( 'document.getElementById("'+elementId+'").style.backgroundColor = "'+RGBToHex( changes )+'";', timeBetweenSteps*(i-1) );
	}
	nlbFade_t[nlbFade_elemTableId] = nlbFade_s;
}
function hexToRGB( hexVal )
{
	hexVal = hexVal.toUpperCase( );
	if( hexVal.substring( 0, 1 ) == '#' )
		hexVal = hexVal.substring( 1 );
	var hexArray = new Array( );
	var rgbArray = new Array( );
	hexArray[0] = hexVal.substring( 0, 2 );
	hexArray[1] = hexVal.substring( 2, 4 );
	hexArray[2] = hexVal.substring( 4, 6 );
	for( var k = 0; k < hexArray.length; k++ )
	{
		var num = hexArray[k];
		var res = 0;
		var j = 0;
		for( var i = num.length - 1; i >= 0; i-- )
			res += parseInt( nlbFade_hextable.indexOf( num.charAt( i ) ) ) * Math.pow( 16, j++ );
		rgbArray[k] = res;
	}
	return rgbArray;
}
function RGBToHex( rgbArray )
{
	var retval = new Array( );
	for( var j = 0; j < rgbArray.length; j++ )
	{
		var result = new Array( );
		var val = rgbArray[j];
		var i = 0;
		while( val > 16 )
		{
			result[i++] = val%16;
			val = Math.floor( val/16 );
		}
		result[i++] = val%16;
		var out = '';
		for( var k = result.length - 1; k >= 0; k-- )
			out += nlbFade_hextable[result[k]];
		retval[j] = padLeft( out, '0', 2 );
	}
	out = '#';
	for( var i = 0; i < retval.length; i++ )
		out += retval[i];
	return out;
}
if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function( val, fromIndex ) {
		if( typeof( fromIndex ) != 'number' ) fromIndex = 0;
		for( var index = fromIndex, len = this.length; index < len; index++ )
			if( this[index] == val ) return index;
		return -1;
	}
}
function padLeft( string, character, paddedWidth )
{
	if( string.length >= paddedWidth )
		return string;
	else
	{
		while( string.length < paddedWidth )
			string = character + string;
	}
	return string;
}