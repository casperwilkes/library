/**
 * Loops through object and returns methods
 * @param  {Object} obj The object to loop through
 * @return {Void}
 */
function getMethods(obj) {
    var res = [];
    for (var m in obj) {
        if (typeof obj[m] == "function") {
            res.push(m);
        }
    }
    
    log.info('Functions:\n' + res.join('\n\r'));
}