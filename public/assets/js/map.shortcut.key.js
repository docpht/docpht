
/*!
 * This file is part of the DocPHT project.
 * 
 * @author Valentino Pesce
 * @copyright (c) Valentino Pesce <valentino@iltuobrand.it>
 * @copyright (c) Craig Crosby <creecros@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$.key("ctrl+alt+p", function() {
    document.getElementById("sk-newPage").click();
});

$.key("ctrl+alt+s", function() {
    $('#sidebarCollapse').trigger('click');
});

$.key("ctrl+alt+k", function() {
    document.getElementById("sk-search").click();
});

$.key("ctrl+alt+z", function() {
    $('#sk-goback').trigger('click');
});

$.key("ctrl+alt+enter", function() {
    document.getElementById("sk-login").click();
});

$.key("ctrl+alt+o", function() {
    document.getElementById("sk-logout").click();
});

$.key("ctrl+alt+a", function() {
    document.getElementById("sk-admin").click();
});

$.key("ctrl+alt+e", function() {
    document.getElementById("sk-add").click();
});

$.key("ctrl+alt+u", function() {
    document.getElementById("sk-update").click();
});

$.key("ctrl+alt+d", function() {
    $('#sk-delete').trigger('click');
});