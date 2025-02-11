/*
This script is a modified version of Alex benenson's cyrillic translitarator
*/


// default latinica - russian-oriented customized tranlit readable both ways
var defaultLatinicaTable = [["shch", "\u0429"],["yo", "\u0401"],["zh",
"\u0416"],["ch", "\u0427"],["sh", "\u0428"],["yu", "\u042E"],["ya",
"\u042F"],["e\'", "\u042D"],["eh", "\u042D"],["sj", "\u0429"],["a",
"\u0410"],["b", "\u0411"],["v","\u0412"],["g", "\u0413"],["d",
"\u0414"],["e", "\u0415"],["z", "\u0417"],["i", "\u0418"],["j",
"\u0419"],["k", "\u041A"],["l", "\u041B"],["m", "\u041C"],["n",
"\u041D"],["o", "\u041E"],["p", "\u041F"],["r", "\u0420"],["s",
"\u0421"],["t", "\u0422"],["u", "\u0423"],["f", "\u0424"],["``",
"\u042A"],["`", "\u044A", true],["y","\u042B"],["\'\'", "\u042C"],["\'",
"\u044C", true],["x", "\u0425"],["h", "\u0425"],["c", "\u0426"],["kh",
"\u0425"],["ji", "\u0406"],["jj","\u0407"],["w","\u040E"],["q", "'"],["\\", "'"],["´", "'"],["je","\u0404"]];

var amhaHash='{"h":"ህ","ህe":"ሀ","ህu":"ሁ","ህi":"ሂ","ህa":"ሃ","ሀe":"ሄ","ህE":"ሄ","ህo":"ሆ","ህW":"ኋ","ህh":"ኅ","ህ2":"ኅ","ኅe":"ኅ","ኅu":"ኁ","ኅi":"ኂ","ኅa":"ኃ","ኀe":"ኄ","ኅE":"ኄ","ኅo":"ኆ","ኅW":"ኋ","ኋe":"ኈ","ኋu":"ኍ","ኋi":"ኊ","ኋa":"ኋ","ኈe":"ኌ","ኋE":"ኌ","ኋ\'":"ኍ","l":"ል","L":"ል","ልe":"ለ","ልu":"ሉ","ልi":"ሊ","ልa":"ላ","ለe":"ሌ","ልE":"ሌ","ልo":"ሎ","ልW":"ሏ","ሏa":"ሏ","H":"ሕ","ሕe":"ሐ","ሕu":"ሑ","ሕi":"ሒ","ሕa":"ሓ","ሐe":"ሔ","ሕE":"ሔ","ሕo":"ሖ","ሕW":"ሗ","ሗa":"ሗ","m":"ም","M":"ም","ምe":"መ","ምu":"ሙ","ምi":"ሚ","ምa":"ማ","መe":"ሜ","ምE":"ሜ","ምo":"ሞ","ምW":"ሟ","ሟa":"ሟ","ምY":"ፙ","ፘa":"ፙ","r":"ር","R":"ር","ርe":"ረ","ርu":"ሩ","ርi":"ሪ","ርa":"ራ","ረe":"ሬ","ርE":"ሬ","ርo":"ሮ","ርW":"ሯ","ሯa":"ሯ","ርY":"ፘ","s":"ስ","ስe":"ሰ","ስu":"ሱ","ስi":"ሲ","ስa":"ሳ","ሰe":"ሴ","ስE":"ሴ","ስo":"ሶ","ስW":"ሷ","ሷa":"ሷ","ስs":"ሥ","ስ2":"ሥ","ሥe":"ሠ","ሥu":"ሡ","ሥi":"ሢ","ሥa":"ሣ","ሠe":"ሤ","ሥE":"ሤ","ሥo":"ሦ","ሥW":"ሧ","ሧa":"ሧ","x":"ሽ","X":"ሽ","ሽe":"ሸ","ሽu":"ሹ","ሽi":"ሺ","ሽa":"ሻ","ሸe":"ሼ","ሽE":"ሼ","ሽo":"ሾ","ሽW":"ሿ","ሿa":"ሿ","q":"ቅ","ቅe":"ቀ","ቅu":"ቁ","ቅi":"ቂ","ቅa":"ቃ","ቀe":"ቄ","ቅE":"ቄ","ቅo":"ቆ","ቅW":"ቋ","ቋe":"ቈ","ቋu":"ቍ","ቋi":"ቊ","ቋa":"ቋ","ቈe":"ቌ","ቋE":"ቌ","ቋ\'":"ቍ","Q":"ቕ","ቕe":"ቐ","ቕu":"ቑ","ቕi":"ቒ","ቕa":"ቓ","ቐe":"ቔ","ቕE":"ቔ","ቕo":"ቖ","ቕW":"ቛ","ቛe":"ቘ","ቛu":"ቘ","ቛi":"ቚ","ቛa":"ቛ","ቘe":"ቜ","ቛe":"ቜ","ቛa":"ቝ","b":"ብ","B":"ብ","ብe":"በ","ብu":"ቡ","ብi":"ቢ","ብa":"ባ","በe":"ቤ","ብE":"ቤ","ብo":"ቦ","ብW":"ቧ","ቧa":"ቧ","v":"ቭ","V":"ቭ","ቭe":"ቨ","ቭu":"ቩ","ቪi":"ቩ","ቭa":"ቫ","ቭE":"ቬ","ቭE":"ቬ","ቭo":"ቮ","ቭW":"ቯ","ቯa":"ቯ","t":"ት","ትe":"ተ","ትu":"ቱ","ትi":"ቲ","ትa":"ታ","ተe":"ቴ","ትE":"ቴ","ትo":"ቶ","ትW":"ቷ","ትW":"ቷ","c":"ች","ችe":"ቸ","ችu":"ቹ","ችi":"ቺ","ችa":"ቻ","ቸe":"ቼ","ችE":"ቼ","ችo":"ቾ","ችW":"ቿ","ቿa":"ቿ","n":"ን","ንe":"ነ","ንu":"ኑ","ንi":"ኒ","ንa":"ና","ነe":"ኔ","ንE":"ኔ","ንo":"ኖ","ንW":"ኗ","ኗa":"ኗ","N":"ኝ","ኝe":"ኘ","ኝu":"ኙ","ኝi":"ኚ","ኝa":"ኛ","ኘe":"ኜ","ኝE":"ኜ","ኝo":"ኞ","ኝW":"ኟ","ኟa":"ኟ","a":"አ","u":"ኡ","U":"ኡ","i":"ኢ","A":"ኣ","E":"ኤ","e":"እ","I":"እ","እe":"ዕ","ዕe":"ዐ","እa":"ኧ","o":"ኦ","O":"ኦ","አa":"ዓ","አe":"ዐ","አ2":"ዐ","ኡu":"ዑ","ኡU":"ዑ","ኡ2":"ዑ","ኢi":"ዒ","ኢ2":"ዒ","ኣa":"ዓ","ኣA":"ዓ","ኣ2":"ዓ","ኤE":"ዔ","ኤ2":"ዔ","እI":"ዕ","እ2":"ዕ","ኦo":"ዖ","ኦO":"ዖ","ኦ2":"ዖ","k":"ክ","ክe":"ከ","ክu":"ኩ","ክi":"ኪ","ክa":"ካ","ከe":"ኬ","ክE":"ኬ","ክo":"ኮ","ክW":"ኳ","ኳe":"ኰ","ኮo":"ኰ","ኳu":"ኵ","ኳi":"ኲ","ኳa":"ኳ","ኰe":"ኴ","ኳE":"ኴ","ኳ\'":"ኵ","K":"ኽ","ኽe":"ኸ","ኽu":"ኹ","ኽi":"ኺ","ኽa":"ኻ","ኸe":"ኼ","ኽE":"ኼ","ኽo":"ኾ","ኽW":"ዃ","ዃe":"ዀ","ዃu":"ዅ","ዃi":"ዂ","ዃa":"ዃ","ዀu":"ዄ","ዃE":"ዄ","ዃ\'":"ዅ","w":"ው","W":"ው","ውe":"ወ","ውu":"ዉ","ውi":"ዊ","ውa":"ዋ","ወE":"ዌ","ውE":"ዌ","ውo":"ዎ","z":"ዝ","ዝe":"ዘ","ዝu":"ዙ","ዝi":"ዚ","ዝa":"ዛ","ዘE":"ዜ","ዝE":"ዜ","ዝo":"ዞ","ዝW":"ዟ","ዟa":"ዟ","Z":"ዥ","ዥe":"ዠ","ዥu":"ዡ","ዥi":"ዢ","ዥa":"ዣ","ዠe":"ዤ","ዥE":"ዤ","ዥo":"ዦ","ዥW":"ዧ","ዧa":"ዧ","y":"ይ","Y":"ይ","ይe":"የ","ይu":"ዩ","ይi":"ዪ","ይa":"ያ","የe":"ዬ","ይE":"ዬ","ይo":"ዮ","d":"ድ","ድe":"ደ","ድu":"ዱ","ድi":"ዲ","ድa":"ዳ","ደe":"ዴ","ድE":"ዴ","ድo":"ዶ","ድW":"ዷ","ዷa":"ዷ","D":"ዽ","ዽe":"ዸ","ዽu":"ዹ","ዽi":"ዺ","ዽa":"ዻ","ዸe":"ዼ","ዽE":"ዼ","ዽo":"ዾ","ዽW":"ዿ","ዿa":"ዿ","j":"ጅ","J":"ጅ","ጅe":"ጀ","ጅu":"ጁ","ጅi":"ጂ","ጅa":"ጃ","ጀe":"ጄ","ጅE":"ጄ","ጅo":"ጆ","ጅW":"ጇ","ጇa":"ጇ","g":"ግ","ግe":"ገ","ግu":"ጉ","ግi":"ጊ","ግa":"ጋ","ገe":"ጌ","ግE":"ጌ","ግo":"ጎ","ግW":"ጓ","ጓe":"ጐ","ጎo":"ጐ","ጓu":"ጕ","ጓi":"ጒ","ጓa":"ጓ","ጐe":"ጔ","ጓE":"ጔ","ጓ\'":"ጕ","G":"ጝ","ጝe":"ጘ","ጝu":"ጙ","ጝi":"ጚ","ጝa":"ጛ","ጘe":"ጜ","ጝE":"ጜ","ጝo":"ጞ","T":"ጥ","ጥe":"ጠ","ጥu":"ጡ","ጥi":"ጢ","ጥa":"ጣ","ጠe":"ጤ","ጥE":"ጤ","ጥo":"ጦ","ጥW":"ጧ","ጧa":"ጧ","C":"ጭ","ጭe":"ጨ","ጭu":"ጩ","ጭi":"ጪ","ጭa":"ጫ","ጨe":"ጬ","ጭE":"ጬ","ጭo":"ጮ","ጭW":"ጯ","ጯa":"ጯ","P":"ጵ","ጵe":"ጰ","ጵu":"ጱ","ጵi":"ጲ","ጵa":"ጳ","ጰe":"ጴ","ጵE":"ጴ","ጵo":"ጶ","ጵW":"ጷ","ጷa":"ጷ","S":"ጽ","ጽe":"ጸ","ጽu":"ጹ","ጽi":"ጺ","ጽa":"ጻ","ጸe":"ጼ","ጽE":"ጼ","ጽo":"ጾ","ጽW":"ጿ","ጿa":"ጿ","ጽS":"ፅ","ጽ2":"ፅ","ፅe":"ፀ","ፅu":"ፁ","ፅi":"ፂ","ፅa":"ፃ","ፀe":"ፄ","ፅE":"ፄ","ፅo":"ፆ","f":"ፍ","F":"ፍ","ፍe":"ፈ","ፍu":"ፉ","ፍi":"ፊ","ፍa":"ፋ","ፈe":"ፌ","ፍE":"ፌ","ፍo":"ፎ","ፍW":"ፏ","ፏa":"ፏ","ፍY":"ፚ","ፚa":"ፚ","p":"ፕ","ፕe":"ፐ","ፕu":"ፑ","ፕi":"ፒ","ፕa":"ፓ","ፐe":"ፔ","ፕE":"ፔ","ፕW":"ፗ","ፗW":"ፗ","ፗa":"ፗ","ፕo":"ፖ","\'":"\'","\'1" :"፩","\'2":"፪","\'3" :"፫","\'4" :"፬","\'5":"፭","\'6":"፮","\'7":"፯","\'8":"፰","\'9" :"፱","፩0":"፲"}';

 
var conversionTable = defaultLatinicaTable;



// for compatibility with bookmarklets
function cyr_translit(src) {
	return to_cyrillic(src);
}

var conversionHash = undefined;
var maxcyrlength = 0;

function getConversionHash() {
	if (conversionHash == undefined) {
		conversionHash = eval("("+amhaHash+")");
		 maxcyrlength=2;
	}

	return conversionHash;
}


function to_cyrillic(src, output, chunks) {
	if (src == undefined || src == "" || src == null)
		return src;
	if (output == undefined)
		output = new String();

	var hash = getConversionHash();
	
	var location = 0;
	
	while (location < src.length) {
		var len = Math.min(maxcyrlength, src.length - location);
		var arr = undefined;
		var sub;
		while (len > 0) {
			sub = src.substr(location, len);
			arr = hash[sub];
			if (arr != undefined) 
				break;
			else 
				len--;
		}
		
		// need this for translit on the fly
		if (chunks != undefined)
			chunks[chunks.length] = sub;
			
		if (arr == undefined) {
			output += sub;
			location ++;
		}
		else {

			// case analysis
			var newChar = arr;
			
			if (sub.toLowerCase() == sub.toUpperCase() && arr.length > 1 && arr[1] && (newChar.toUpperCase() != newChar.toLowerCase())) {
			
				// need translit hash to determine if previous character (and possibly the one before it) 
				// were converted and are in upper case
				
				// set prevDud to true previous is not a translated character or simply a blank
				// set prevCap to true if previous was translated and was upper case

				var prevCh = output.length == 0 ? null : output.substr(output.length - 1, 1);
				var prevDud = !prevCh || !getTranslitString(prevCh);
				var prevCap = (!prevDud && prevCh == prevCh.toUpperCase());

				// sub is caseless but result isn't. case will depend on lookbehind and lookahead
				if (prevDud || !prevCap) {
					output += newChar.toLowerCase();
					prevCap = false;
				}
				else {
					var next = " ";
					if (location + len < src.length)
						next = src.substr(location + len, 1);

					if (next != next.toUpperCase() && next == next.toLowerCase() ) {
						//next is lowercase (and not caseless)
						output += newChar.toLowerCase();
					}
					else if (next == next.toUpperCase() && next != next.toLowerCase() ) {
						// next is uppercase (and not caseless)
						output += newChar.toUpperCase();
					}
					else {
						// next is caseless. output case determined by the case of output[length - 2]
						var pprevCh = output.length == 1 ? null : output.substr(output.length - 2, 1);
						var pprevDud = !pprevCh || !getTranslitString(pprevCh);
						if (!pprevDud && (pprevCh == pprevCh.toUpperCase())) {
							//pre-prev is in upper case. output is also uppercase
							output += newChar.toUpperCase();
						}
						else {
						    output += newChar.toLowerCase();
						}
						
					}
				}
					
			}
			else if ((sub.toLowerCase() == sub.toUpperCase()) && (arr.length < 2 || !arr[1])) {
				
				// literal treatment of newChar
				output += newChar;

			}
			else if (sub != sub.toLowerCase()) {
			
				// sub not all-lowercase
				output += newChar.toUpperCase();
			}
			else {
					
					
					
				// sub is lowercase
			    output += newChar.toLowerCase();
			}
			location += len;
		}
	}
	
	return output;
}

// split string on HTML tags, return array containing both the matches and the pieces of string between them, matches always in even positions - since IE does not support this in String.split
function splitHtmlString(string) {
	var re = /<[\/]?[!A-Z][^>]*>/ig;
	var result = new Array();
	var lastIndex = 0;
	var arr = null;
	while ( (arr = re.exec(string)) != null) {
		result[result.length] = string.substring(lastIndex, arr.index);
		result[result.length] = string.substring(arr.index, re.lastIndex);
		lastIndex = re.lastIndex;
	}
	result[result.length] = string.substr(lastIndex);
	
	return result;
}

/* convert cyrillic to translit using to_translit-- similar to from_translit.... */
function to_translit_ext (src, skipHtml) {
	return convertWithSkip(src, skipHtml, to_translit);
}

/* convert translit to cyrillic (using ToCyrillic.to_cyrillic above) */
function to_cyrillic_ext (src, skipHtml) {
	return convertWithSkip(src, skipHtml, to_cyrillic);
}

function convertIt(src,converter){
 var resultbuffer=""; 
	for(var i=0;i<src.length;i++){
	resultbuffer=converter(resultbuffer+src[i]);
	}
        return converter(resultbuffer);

}

function convertWithSkip(src, skipHtml, converter) {
   
	if (src == "" || src == null)
        return src;
    if (!skipHtml)
	return convertIt(src,converter);
  	 
	 else {
        var arr = splitHtmlString(src);
        
        for (var i = 0; i < arr.length; i++) {
            if ( (i % 2) == 0)
                arr[i] = convertIt(arr[i],converter);
        }

        return arr.join("");
    }
}

var translitHash = undefined;

function initTranslit() {
	if (translitHash == undefined) {
		translitHash = new Array();

		for (var i = 0; i < conversionTable.length; i++) {
			var ch = conversionTable[i][1];
			// if the translit string is not caseless, convert cyr string to upper case
			// otherwise maintain its case
			if (conversionTable[i][0].toUpperCase() != conversionTable[i][0].toLowerCase())
				ch = ch.toUpperCase();
				
			if (translitHash[ch] == undefined)
				translitHash[ch] = conversionTable[i][0];
		}
	}
}


/* convert cyrillic to translit */
function getTranslitString(ch) {
	initTranslit();
		
	var value = translitHash[ch];
	if (value == undefined)
		value = translitHash[ch.toUpperCase()];
	return value;
}

function to_translit(src) {
	if (src == undefined || src == "" || src == null)
		return src;
	
	
	var output = new String();
	for (var i = 0; i < src.length; i++) {
		var ch = src.substr(i, 1);
		var value = getTranslitString(ch);
		if (value != undefined) {
			if (ch != ch.toUpperCase()) {
				output += value.toLowerCase();
			}
			else {
				prev = i == 0 ? null : src.substr(i - 1, 1);
				next = i == src.length - 1 ? null : src.substr(i + 1, 1);
				if ( value.length == 1 ||
				   (prev && prev == prev.toUpperCase()) ||
				   (next && next == next.toUpperCase())) {
				     // completely capitalize
				     output += value.toUpperCase();
				}
				else {
					 // capitalize first letter
					 output += value.substr(0, 1).toUpperCase() + value.substr(1).toLowerCase();
				}
			}
		}
		else
			output += ch;
	}

	return output;
}

//-- translit on-the-fly -- 

function replaceValue(node, value, stepback) {
	if (stepback == undefined)
		stepback = 0;
		
	if (isExplorer()) {
		var range = document.selection.createRange();
		range.moveStart("character", -stepback);
		range.text = value;
		range.collapse(false);
		range.select();
	}
	else {
		var scrollTop = node.scrollTop;
		var cursorLoc =  node.selectionStart;
		node.value = node.value.substring(0, node.selectionStart - stepback) + value + 
                node.value.substring(node.selectionEnd, node.value.length);
		node.scrollTop = scrollTop;
		node.selectionStart = cursorLoc + value.length - stepback;
		node.selectionEnd = cursorLoc + value.length - stepback;
	}
}


// compare positions
function positionIsEqual(other) {
	if (isExplorer())
		return this.position.isEqual(other.position);
	else
		return this.position == other.position;
  
}

function Position(node) {
  if (node.selectionStart != undefined)
	this.position = node.selectionStart;
  else if (document.selection && document.selection.createRange())
    this.position = document.selection.createRange();
    
  this.isEqual = positionIsEqual;
}

function resetState() {
	this.position = new Position(this.node);
	this.transBuffer = "";
	this.cyrBuffer = "";
}

function StateObject(node) {
	this.node = node;
	this.reset = resetState;
	this.cyrBuffer = "";
	this.transBuffer = "";
	this.position = new Position(node);
}


var stateHash = new Array();

function isExplorer() {
  return (document.selection != undefined && document.selection.createRange().isEqual != undefined);
}

function pressedKey(event) {
  if (isExplorer())
	return event.keyCode;
  else
    return event.which;
}

function translateOnKeyPress(event,lang) {
	//alert(lang);
	if(lang != 1) return true;
	
    if (event == undefined)
		event = window.event;
    
	var node = null;
	if (event.target)
		node = event.target;
	else if (event.srcElement)
		node = event.srcElement;
	
	// initialize state
	var state = stateHash[node];
	if (state == null  || state.node != node) {
		state = new StateObject(node);
		stateHash[node] = state;
	}
	
	if ( (event.getCharCode() > 20)/* && !event.ctrlKey && !event.altKey && !event.metaKey*/) {
		
		var c = String.fromCharCode(event.getCharCode());

		// process input
		var result = process_translit(state, c);
		
		// finish up
		if (c != result.out || result.replace != 0) {
		  if (isExplorer())
			event.returnValue = false;
		  else
		    event.preventDefault();
		  
		  replaceValue(node, result.out, result.replace);
		  
		  state.position = new Position(node);

		}
	}
	
}

function TranslitResult() {
	this.out = "";
	this.replace = 0;
}

function process_translit(state, c) {
	// reset state if position changed
	if (!state.position.isEqual(new Position(state.node)))
		state.reset();
		
	var result = new TranslitResult();
	
	// initial backbuffer. Add to it as characters are converted
	var backbuffer = getBackBuffer(state.node, state.cyrBuffer.length, 2);
	var chunks = new Array();
	
	state.transBuffer = state.transBuffer + c

	var str = to_cyrillic(state.cyrBuffer+c, backbuffer, chunks);

	// remove backbuffer from output
	str = str.substr(backbuffer.length);
	result.out = str; 
	/* str is now left alone - it has the output matching contents of chunks and 
	   will be used to reinitialize backbuffers, along with chunks and state.transBuffer
	*/
	
	// get the difference between state.cyrBuffer and output
	for (var i = 0; i < Math.min(state.cyrBuffer.length, result.out.length); i++) {
		if (state.cyrBuffer.substr(i, 1) != result.out.substr(i, 1)) {
			result.replace = state.cyrBuffer.length - i;
			result.out = result.out.substr(i);
			break;
		}
	}
	if (result.replace == 0) {
		result.out = result.out.substr(Math.min(state.cyrBuffer.length, result.out.length));
	}
	
	// update state: backbuffer, bufferArray
	if (chunks.length > 0 && chunks[chunks.length - 1] == result.out.substr(result.out.length - 1)) {
		// no convertion took place, reset state
		state.reset();
	}
	else {
		while (state.transBuffer.length > maxcyrlength) {
			state.transBuffer = state.transBuffer.substr(chunks[0].length);
			chunks.shift();
			str = str.substr(1);
		}
		state.cyrBuffer = str;
	}
	return result;
}

function getBackBuffer(node, offset, count) {
		
	if (isExplorer()) { //.tagName.toUpperCase() == "EDITOR") {
	
		var range = document.selection.createRange();
		range.moveStart("character", -offset);
		var result = range.text.substr(-count);
		if (!result)
			result = "";
			
		return result;

	} else {
		return node.value.substring(0, node.selectionStart - offset).substr(-count);
	}
}

// need this for bookmarklets
function getSelectedNode() {
  if (document.activeElement)
	return document.activeElement;
  else
    if (window.getSelection && window.getSelection() && window.getSelection().rangeCount > 0) {
		var range = window.getSelection().getRangeAt(0);
		if (range.startContainer && range.startContainer.childNodes && range.startContainer.childNodes.length > range.startOffset)
			return range.startContainer.childNodes[range.startOffset]
    }
  return null;
}

function toggleCyrMode() {
	var node = getSelectedNode();
	if (node) {
		if (stateHash[node]) {
			if (removeKeyEventListener(node))
				delete stateHash[node];
		}
		else {
			if (addKeyEventListener(node))
				stateHash[node] = new StateObject(node);
		}
	}
}

function addKeyEventListener(node) {
	if (node.addEventListener)
		node.addEventListener("keypress", translitonkey, false);
	else if (node.attachEvent)
	    node.attachEvent("onkeypress", translitonkey);
	else return false;
	return true;
}
function removeKeyEventListener(node) {
	if (node.removeEventListener)
		node.removeEventListener("keypress", translitonkey, false);
	else if (node.detachEvent)
		node.detachEvent("onkeypress", translitonkey);
	else return false;
	return true;
}

function getSelectedText() {
	if (isExplorer()) {
		return document.selection.createRange().text;
	}
	else {
		var node = getSelectedNode();
		if (node && node.value && node.selectionStart != undefined && node.selectionEnd != undefined)
			return node.value.substring(node.selectionStart, node.selectionEnd);
	}
	return "";
}


function bmkToCyrillic() {
	batchConverter(to_cyrillic_ext);
}
function bmkToTranslit() {
	batchConverter(to_translit_ext);
	
}


function RangeConversionState(range, converter) {
	this.range = range;
	this.convert = converter;
	this.started = false;
	this.finished = false;
	this.toString = function() {
		return "started : " + this.started + ", finished: " + this.finished;
	};
}

function convertRangeNode(node, state) {
	if (state.started && state.finished)
		return;

	if (!state.started && 
		( ( (state.range.startContainer.nodeType == node.TEXT_NODE || 
			 state.range.startContainer.nodeType == node.PROCESSING_INSTRUCTION_NODE || 
			 state.range.startContainer.nodeType == node.COMMENT_NODE	)
		    && node == state.range.startContainer) 
			||
		  ( state.range.startContainer.childNodes && node == state.range.startContainer.childNodes[state.range.startOffset])
		))
		state.started = true;

	if (node.nodeType == node.TEXT_NODE || node.nodeType == node.PROCESSING_INSTRUCTION_NODE || node.nodeType == node.COMMENT_NODE) {
		if (state.started && !state.finished) {
			// convert text
			var start = (node == state.range.startContainer) ? state.range.startOffset : 0;
			var end   = (node == state.range.endContainer) ? state.range.endOffset : node.nodeValue.length;
			var remainder = (node == state.range.endContainer) ? node.nodeValue.length - state.range.endOffset : 0;
			node.nodeValue = 
				node.nodeValue.substring(0, start) +
				state.convert(node.nodeValue.substring(start, end)) +
				node.nodeValue.substr(end);
			
			if (node == state.range.endContainer)
				state.range.setEnd(node, node.nodeValue.length - remainder);
			if (node == state.range.startContainer)
				state.range.setStart(node, start);
		}
	}
	else if (node.childNodes)
		// walk the tree
		for (var i = 0; i < node.childNodes.length; i++) {
			convertRangeNode(node.childNodes[i], state);
			if (state.started && state.finished)
				break;
		}
		
	if (!state.finished && 
		( ((state.range.endContainer.nodeType == node.TEXT_NODE || 
			 state.range.endContainer.nodeType == node.PROCESSING_INSTRUCTION_NODE || 
			 state.range.endContainer.nodeType == node.COMMENT_NODE	)
		     && node == state.range.endContainer) 
			||
		  ( (state.range.endContainer.childNodes.length > 0) && node == state.range.endContainer.childNodes[state.range.endOffset - 1])
		))
		state.finished = true;
		
}

function convertSelection (selection, converter) {
	if (selection == null) return;
	for(var i = 0; i < selection.rangeCount; i++) {
		convertRangeNode(selection.getRangeAt(i).commonAncestorContainer, new RangeConversionState(selection.getRangeAt(i), converter));
	}
	selection.collapseToEnd();
}


function batchConverter(convert) {
	if (isExplorer()) {
		var range = document.selection.createRange();
		try {
			range.pasteHTML(convert(range.htmlText, true));
		}
		catch (err) {
			range.text = convert(range.text, true);
		}
	}
	else if (window.getSelection) {
		var node = getSelectedNode();
		var sel = window.getSelection();

		if (node && node.value && node.selectionStart != undefined && node.selectionEnd != undefined)
			replaceValue(node, convert(node.value.substring(node.selectionStart, node.selectionEnd), true));
		else if(sel && sel.toString() != "")
			convertSelection(sel, convert);
	}
}


function writeTheTable() {
	var hash=getConversionHash();

	for (var ch in hash){
		document.write("<div><span>"+hash[ch]+"</span>"+ch+"</div>\n");
	}
}
function convertAll() {
	var area = document.getElementById("comment");
	area.value = to_cyrillic_ext(area.value, document.getElementById("skipHTML").checked);
}

function convertSelected() {
	if(document.selection && document.selection.createRange()){ // ie
		var range = document.selection.createRange();
		range.text = to_cyrillic_ext(range.text, document.getElementById("skipHTML").checked);
	}
	else { // mozilla, everything else
		var comment = document.getElementById("comment");

		var str;

		if (comment.selectionStart != undefined) {

			var str = comment.value.substr(0, comment.selectionStart) +
			to_cyrillic_ext(comment.value.substring(comment.selectionStart,
			comment.selectionEnd), document.getElementById("skipHTML").checked) +
			comment.value.substr(comment.selectionEnd);

		} else {
			//str = do_translit(comment.value, document.getElementById("skipHTML").checked); 
			alert("This feature is not supported by your browser. Please use \"Convert All\"");
			str = comment.value;

		}
		comment.value = str;

	}
}

function convertToTranslit() {
	var area = document.getElementById("comment");
	area.value = to_translit(area.value);
}

function processKeys(event) {
	if (rtsupported) {
		if (event.keyCode == 27 && !isExplorer()) { //escape to toggle
			realTime = !realTime;
			document.getElementById("realtime").checked = realTime;

		}
		else if (realTime)
			translitonkey(event);
	}
}


var realTime = true;
function rtClick(event) {
	realTime = !realTime;
	document.getElementById('comment').focus(); 
}

var rtsupported = false;
try {
	/*
	var nav = navigator.userAgent.toUpperCase();
	rtsupported = (nav.indexOf("GECKO") >= 0 || nav.indexOf("OPERA") >= 0 || nav.indexOf("SAFARI") >= 0);
	*/

	rtsupported = (document.selection != undefined)
	if (!rtsupported) {
		var element = document.createElement("TEXTAREA");
		document.getElementsByTagName("BODY")[0].appendChild(element);
		if (element.selectionStart != undefined)
		rtsupported = true;
		document.getElementsByTagName("BODY")[0].removeChild(element);
	}

	} catch (error) {

}


var maximized = false;
function toggle() {
	var transliterator = document.getElementById("transliterator");
	var main = document.getElementById("main");
	var button = document.getElementById("btnmaximize");
	var comment = document.getElementById("comment");
	var transbottom = document.getElementById("transbottom");
	var sidebar = document.getElementById("sidebar");
	if (!maximized) {
		//transliterator.className = "max";
		main.className = "max";
		//body.style.background = "inherit";
		button.title = "Restore";
		//document.body.style.overflow = "hidden";
		document.documentElement.style.overflow = "hidden";
		document.documentElement.style.height = "100%";
		document.body.style.height = "100%";
		//comment.className = "comment-max";
		//button.className = "btnmaximize-max";
		//transbottom.className = "transbottom-max";
		sidebar.style.display = "none";
	}
	else {
		//document.getElementById("transliterator").className = "transliterator-reg";
		//document.body.style.background = "none";
		button.title = "Maximize";
		//button.className = "";
		main.className = "";
		//document.body.style.overflow = "auto";
		document.documentElement.style.overflow = "auto";
		document.documentElement.style.height = "auto";
		document.body.style.height = "auto"; 
		//comment.className = "";
		//transbottom.className = "";
		sidebar.style.display = "block";
	}
	maximized = !maximized;

}

function openHelp() 
{ 
	window.open('http://ethioforum.org/wp/amharic/amharic.html','jav','width=550,height=600,resizable=yes,scrollbars=yes'); 
} 

function openHelp2() { 
	window.open('http://ethioforum.org/wp/amharic/keyboard.html','jav2','width=700,height=400,resizable=yes,scrollbars=yes'); 
} 

	  
<!-- Begin
function copyme(theField) {
	var tempval=eval("document."+theField)
	tempval.focus()
	tempval.select()
	therange=tempval.createTextRange()
	therange.execCommand("Copy")
}

