/**
 * 2017-2019 Buy Addons Team
*
* NOTICE OF LICENSE
*
* This source file is subject to the GNU General Public License version 3
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://www.opensource.org/licenses/gpl-3.0.html
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@buy-addons.com so we can send you a copy immediately.
*
* @author Buy Addons Team <hatt@buy-addons.com>
* @copyright  2017-2019 Buy Addons Team
* @license   http://www.opensource.org/licenses/gpl-3.0.html  GNU General Public License version 3
* International Registered Trademark & Property of Buy Addons Team
*/
 
/* 
## REMOVE IF USED OUTSIDE OF CODEPEN!!!
## Codepen fix: infinite loop protection.
## window.CP is undefined. Why? 
*/
window.CP = {};
window.CP.shouldStopExecution = function() {};
window.CP.exitedLoop = function() {};
/*
## end Codepen fix
*/

const switches = document.querySelectorAll(".switch > span");

/* 
## Enable radio input de-selection.
## Can be removed if only using checkboxes.
*/
for (let i = 0; i < switches.length; i++) {
  const switchEl = switches[i];
  const inputEl = switchEl.previousElementSibling;

  if (inputEl.type === 'radio') {
    const labelEl = inputEl.parentElement;
    labelEl.addEventListener('click', function(evt) {
      
      evt.preventDefault();
      evt.stopPropagation();
      
      inputEl.checked = !inputEl.checked;  
    });
  }
}

/* 
## Enable draggable switching.
*/
let startX;
let startY;
let ghostNode = {};

for (let i = 0; i < switches.length; i++) {
 
  const switchEl = switches[i];

  switchEl.draggable = true;
  
  ['dragstart', 'touchstart'].forEach(function(e) {
    switchEl.addEventListener(e, onDragStart);
  });
  
  ['dragover', 'touchmove'].forEach(function(e) {
    switchEl.addEventListener(e, onDragOver);
  });
  
  ['dragend', 'touchend'].forEach(function(e) {
    switchEl.addEventListener(e, onDragEnd);
  });
  
}

function onDragStart(evt) {
  evt = evt || window.event;
  const x = evt.pageX,
        y = evt.pageY;
  startX = x;
  startY = y;

  if (evt.type == 'dragstart') {
    evt.dataTransfer.setData('text/plain', '');

    /* 
    ## Remove drag preview.
    ## Safari: node must have content (&nbsp;)
    ## otherwise dragend event will fire immediately.
    */
    ghostNode = document.createElement("div");
    ghostNode.innerHTML = "&nbsp;";
    ghostNode.style.visibility = 'hidden';
    document.body.appendChild(ghostNode);
    evt.dataTransfer.setDragImage(ghostNode, 0, 0);   
  }
}

function onDragOver(evt) {
  evt = evt || window.event;

  evt.preventDefault();

  const x = evt.pageX,
        y = evt.pageY;

  const switchRect = evt.currentTarget.getBoundingClientRect();
  const checkbox = evt.currentTarget.previousElementSibling;
  
  if (checkbox.disabled) {
    return;
  }

  if (checkbox.checked && x <= startX - 10) {
    checkbox.checked = false;
  } else if (!checkbox.checked && x >= startX + 10) {
    checkbox.checked = true;
  }
}

function onDragEnd(evt) { 
  // ## Remove ghostNode from DOM.
  if (evt.type == 'dragend') {
    ghostNode.parentNode.removeChild(ghostNode);
  }

  return;
}