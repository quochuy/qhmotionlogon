<?php
/**
 * phpDollar
 * 
 * PHP implementation of $1 Unistroke Recognizer with Protractor enhancement
 * http://depts.washington.edu/aimgroup/proj/dollar/
 * 
 * Copyright (c) Mateusz Krzeszowiak - matkrzesz[at]gmail[dot]com | http://twitter.com/matkrzesz
 * 
 * You can use it however you want, just please, leave orgiginal author note.
 */
class phpDollar{
    
    private $_numPoints = 64;
    private $_squareSize = 250.0;
    private $_originPoint = array('x'=>0, 'y'=>0);
    /**
     * Array with templates, every template is an array of points. 
     * Example of point:
     *  array('x' => 0, 'y' => 0);
     */
    private $_templatesArray = array();
    
    /**
     * Class constructor, you can add here predefined templates by addTemplate() function
     */
    public function phpDollar() {
    	/*
        $this->addTemplate('triangle', array(array('x'=>137, 'y'=>139), array('x'=>135, 'y'=>141), array('x'=>133, 'y'=>144), array('x'=>132, 'y'=>146), array('x'=>130, 'y'=>149), array('x'=>128, 'y'=>151), array('x'=>126, 'y'=>155), array('x'=>123, 'y'=>160), array('x'=>120, 'y'=>166), array('x'=>116, 'y'=>171), array('x'=>112, 'y'=>177), array('x'=>107, 'y'=>183), array('x'=>102, 'y'=>188), array('x'=>100, 'y'=>191), array('x'=>95, 'y'=>195), array('x'=>90, 'y'=>199), array('x'=>86, 'y'=>203), array('x'=>82, 'y'=>206), array('x'=>80, 'y'=>209), array('x'=>75, 'y'=>213), array('x'=>73, 'y'=>213), array('x'=>70, 'y'=>216), array('x'=>67, 'y'=>219), array('x'=>64, 'y'=>221), array('x'=>61, 'y'=>223), array('x'=>60, 'y'=>225), array('x'=>62, 'y'=>226), array('x'=>65, 'y'=>225), array('x'=>67, 'y'=>226), array('x'=>74, 'y'=>226), array('x'=>77, 'y'=>227), array('x'=>85, 'y'=>229), array('x'=>91, 'y'=>230), array('x'=>99, 'y'=>231), array('x'=>108, 'y'=>232), array('x'=>116, 'y'=>233), array('x'=>125, 'y'=>233), array('x'=>134, 'y'=>234), array('x'=>145, 'y'=>233), array('x'=>153, 'y'=>232), array('x'=>160, 'y'=>233), array('x'=>170, 'y'=>234), array('x'=>177, 'y'=>235), array('x'=>179, 'y'=>236), array('x'=>186, 'y'=>237), array('x'=>193, 'y'=>238), array('x'=>198, 'y'=>239), array('x'=>200, 'y'=>237), array('x'=>202, 'y'=>239), array('x'=>204, 'y'=>238), array('x'=>206, 'y'=>234), array('x'=>205, 'y'=>230), array('x'=>202, 'y'=>222), array('x'=>197, 'y'=>216), array('x'=>192, 'y'=>207), array('x'=>186, 'y'=>198), array('x'=>179, 'y'=>189), array('x'=>174, 'y'=>183), array('x'=>170, 'y'=>178), array('x'=>164, 'y'=>171), array('x'=>161, 'y'=>168), array('x'=>154, 'y'=>160), array('x'=>148, 'y'=>155), array('x'=>143, 'y'=>150), array('x'=>138, 'y'=>148), array('x'=>136, 'y'=>148)));
        $this->addTemplate('x', array(array('x'=>87, 'y'=>142), array('x'=>89, 'y'=>145), array('x'=>91, 'y'=>148), array('x'=>93, 'y'=>151), array('x'=>96, 'y'=>155), array('x'=>98, 'y'=>157), array('x'=>100, 'y'=>160), array('x'=>102, 'y'=>162), array('x'=>106, 'y'=>167), array('x'=>108, 'y'=>169), array('x'=>110, 'y'=>171), array('x'=>115, 'y'=>177), array('x'=>119, 'y'=>183), array('x'=>123, 'y'=>189), array('x'=>127, 'y'=>193), array('x'=>129, 'y'=>196), array('x'=>133, 'y'=>200), array('x'=>137, 'y'=>206), array('x'=>140, 'y'=>209), array('x'=>143, 'y'=>212), array('x'=>146, 'y'=>215), array('x'=>151, 'y'=>220), array('x'=>153, 'y'=>222), array('x'=>155, 'y'=>223), array('x'=>157, 'y'=>225), array('x'=>158, 'y'=>223), array('x'=>157, 'y'=>218), array('x'=>155, 'y'=>211), array('x'=>154, 'y'=>208), array('x'=>152, 'y'=>200), array('x'=>150, 'y'=>189), array('x'=>148, 'y'=>179), array('x'=>147, 'y'=>170), array('x'=>147, 'y'=>158), array('x'=>147, 'y'=>148), array('x'=>147, 'y'=>141), array('x'=>147, 'y'=>136), array('x'=>144, 'y'=>135), array('x'=>142, 'y'=>137), array('x'=>140, 'y'=>139), array('x'=>135, 'y'=>145), array('x'=>131, 'y'=>152), array('x'=>124, 'y'=>163), array('x'=>116, 'y'=>177), array('x'=>108, 'y'=>191), array('x'=>100, 'y'=>206), array('x'=>94, 'y'=>217), array('x'=>91, 'y'=>222), array('x'=>89, 'y'=>225), array('x'=>87, 'y'=>226), array('x'=>87, 'y'=>224)));
        $this->addTemplate('rectangle', array(array('x'=>78, 'y'=>149), array('x'=>78, 'y'=>153), array('x'=>78, 'y'=>157), array('x'=>78, 'y'=>160), array('x'=>79, 'y'=>162), array('x'=>79, 'y'=>164), array('x'=>79, 'y'=>167), array('x'=>79, 'y'=>169), array('x'=>79, 'y'=>173), array('x'=>79, 'y'=>178), array('x'=>79, 'y'=>183), array('x'=>80, 'y'=>189), array('x'=>80, 'y'=>193), array('x'=>80, 'y'=>198), array('x'=>80, 'y'=>202), array('x'=>81, 'y'=>208), array('x'=>81, 'y'=>210), array('x'=>81, 'y'=>216), array('x'=>82, 'y'=>222), array('x'=>82, 'y'=>224), array('x'=>82, 'y'=>227), array('x'=>83, 'y'=>229), array('x'=>83, 'y'=>231), array('x'=>85, 'y'=>230), array('x'=>88, 'y'=>232), array('x'=>90, 'y'=>233), array('x'=>92, 'y'=>232), array('x'=>94, 'y'=>233), array('x'=>99, 'y'=>232), array('x'=>102, 'y'=>233), array('x'=>106, 'y'=>233), array('x'=>109, 'y'=>234), array('x'=>117, 'y'=>235), array('x'=>123, 'y'=>236), array('x'=>126, 'y'=>236), array('x'=>135, 'y'=>237), array('x'=>142, 'y'=>238), array('x'=>145, 'y'=>238), array('x'=>152, 'y'=>238), array('x'=>154, 'y'=>239), array('x'=>165, 'y'=>238), array('x'=>174, 'y'=>237), array('x'=>179, 'y'=>236), array('x'=>186, 'y'=>235), array('x'=>191, 'y'=>235), array('x'=>195, 'y'=>233), array('x'=>197, 'y'=>233), array('x'=>200, 'y'=>233), array('x'=>201, 'y'=>235), array('x'=>201, 'y'=>233), array('x'=>199, 'y'=>231), array('x'=>198, 'y'=>226), array('x'=>198, 'y'=>220), array('x'=>196, 'y'=>207), array('x'=>195, 'y'=>195), array('x'=>195, 'y'=>181), array('x'=>195, 'y'=>173), array('x'=>195, 'y'=>163), array('x'=>194, 'y'=>155), array('x'=>192, 'y'=>145), array('x'=>192, 'y'=>143), array('x'=>192, 'y'=>138), array('x'=>191, 'y'=>135), array('x'=>191, 'y'=>133), array('x'=>191, 'y'=>130), array('x'=>190, 'y'=>128), array('x'=>188, 'y'=>129), array('x'=>186, 'y'=>129), array('x'=>181, 'y'=>132), array('x'=>173, 'y'=>131), array('x'=>162, 'y'=>131), array('x'=>151, 'y'=>132), array('x'=>149, 'y'=>132), array('x'=>138, 'y'=>132), array('x'=>136, 'y'=>132), array('x'=>122, 'y'=>131), array('x'=>120, 'y'=>131), array('x'=>109, 'y'=>130), array('x'=>107, 'y'=>130), array('x'=>90, 'y'=>132), array('x'=>81, 'y'=>133), array('x'=>76, 'y'=>133)));
        $this->addTemplate('circle', array(array('x'=>127, 'y'=>141), array('x'=>124, 'y'=>140), array('x'=>120, 'y'=>139), array('x'=>118, 'y'=>139), array('x'=>116, 'y'=>139), array('x'=>111, 'y'=>140), array('x'=>109, 'y'=>141), array('x'=>104, 'y'=>144), array('x'=>100, 'y'=>147), array('x'=>96, 'y'=>152), array('x'=>93, 'y'=>157), array('x'=>90, 'y'=>163), array('x'=>87, 'y'=>169), array('x'=>85, 'y'=>175), array('x'=>83, 'y'=>181), array('x'=>82, 'y'=>190), array('x'=>82, 'y'=>195), array('x'=>83, 'y'=>200), array('x'=>84, 'y'=>205), array('x'=>88, 'y'=>213), array('x'=>91, 'y'=>216), array('x'=>96, 'y'=>219), array('x'=>103, 'y'=>222), array('x'=>108, 'y'=>224), array('x'=>111, 'y'=>224), array('x'=>120, 'y'=>224), array('x'=>133, 'y'=>223), array('x'=>142, 'y'=>222), array('x'=>152, 'y'=>218), array('x'=>160, 'y'=>214), array('x'=>167, 'y'=>210), array('x'=>173, 'y'=>204), array('x'=>178, 'y'=>198), array('x'=>179, 'y'=>196), array('x'=>182, 'y'=>188), array('x'=>182, 'y'=>177), array('x'=>178, 'y'=>167), array('x'=>170, 'y'=>150), array('x'=>163, 'y'=>138), array('x'=>152, 'y'=>130), array('x'=>143, 'y'=>129), array('x'=>140, 'y'=>131), array('x'=>129, 'y'=>136), array('x'=>126, 'y'=>139)));
        $this->addTemplate('check', array(array('x'=>91, 'y'=>185), array('x'=>93, 'y'=>185), array('x'=>95, 'y'=>185), array('x'=>97, 'y'=>185), array('x'=>100, 'y'=>188), array('x'=>102, 'y'=>189), array('x'=>104, 'y'=>190), array('x'=>106, 'y'=>193), array('x'=>108, 'y'=>195), array('x'=>110, 'y'=>198), array('x'=>112, 'y'=>201), array('x'=>114, 'y'=>204), array('x'=>115, 'y'=>207), array('x'=>117, 'y'=>210), array('x'=>118, 'y'=>212), array('x'=>120, 'y'=>214), array('x'=>121, 'y'=>217), array('x'=>122, 'y'=>219), array('x'=>123, 'y'=>222), array('x'=>124, 'y'=>224), array('x'=>126, 'y'=>226), array('x'=>127, 'y'=>229), array('x'=>129, 'y'=>231), array('x'=>130, 'y'=>233), array('x'=>129, 'y'=>231), array('x'=>129, 'y'=>228), array('x'=>129, 'y'=>226), array('x'=>129, 'y'=>224), array('x'=>129, 'y'=>221), array('x'=>129, 'y'=>218), array('x'=>129, 'y'=>212), array('x'=>129, 'y'=>208), array('x'=>130, 'y'=>198), array('x'=>132, 'y'=>189), array('x'=>134, 'y'=>182), array('x'=>137, 'y'=>173), array('x'=>143, 'y'=>164), array('x'=>147, 'y'=>157), array('x'=>151, 'y'=>151), array('x'=>155, 'y'=>144), array('x'=>161, 'y'=>137), array('x'=>165, 'y'=>131), array('x'=>171, 'y'=>122), array('x'=>174, 'y'=>118), array('x'=>176, 'y'=>114), array('x'=>177, 'y'=>112), array('x'=>177, 'y'=>114), array('x'=>175, 'y'=>116), array('x'=>173, 'y'=>118)));
        $this->addTemplate('caret', array(array('x'=>79, 'y'=>245), array('x'=>79, 'y'=>242), array('x'=>79, 'y'=>239), array('x'=>80, 'y'=>237), array('x'=>80, 'y'=>234), array('x'=>81, 'y'=>232), array('x'=>82, 'y'=>230), array('x'=>84, 'y'=>224), array('x'=>86, 'y'=>220), array('x'=>86, 'y'=>218), array('x'=>87, 'y'=>216), array('x'=>88, 'y'=>213), array('x'=>90, 'y'=>207), array('x'=>91, 'y'=>202), array('x'=>92, 'y'=>200), array('x'=>93, 'y'=>194), array('x'=>94, 'y'=>192), array('x'=>96, 'y'=>189), array('x'=>97, 'y'=>186), array('x'=>100, 'y'=>179), array('x'=>102, 'y'=>173), array('x'=>105, 'y'=>165), array('x'=>107, 'y'=>160), array('x'=>109, 'y'=>158), array('x'=>112, 'y'=>151), array('x'=>115, 'y'=>144), array('x'=>117, 'y'=>139), array('x'=>119, 'y'=>136), array('x'=>119, 'y'=>134), array('x'=>120, 'y'=>132), array('x'=>121, 'y'=>129), array('x'=>122, 'y'=>127), array('x'=>124, 'y'=>125), array('x'=>126, 'y'=>124), array('x'=>129, 'y'=>125), array('x'=>131, 'y'=>127), array('x'=>132, 'y'=>130), array('x'=>136, 'y'=>139), array('x'=>141, 'y'=>154), array('x'=>145, 'y'=>166), array('x'=>151, 'y'=>182), array('x'=>156, 'y'=>193), array('x'=>157, 'y'=>196), array('x'=>161, 'y'=>209), array('x'=>162, 'y'=>211), array('x'=>167, 'y'=>223), array('x'=>169, 'y'=>229), array('x'=>170, 'y'=>231), array('x'=>173, 'y'=>237), array('x'=>176, 'y'=>242), array('x'=>177, 'y'=>244), array('x'=>179, 'y'=>250), array('x'=>181, 'y'=>255), array('x'=>182, 'y'=>257)));
        $this->addTemplate('zig-zag', array(array('x'=>307, 'y'=>216), array('x'=>333, 'y'=>186), array('x'=>356, 'y'=>215), array('x'=>375, 'y'=>186), array('x'=>399, 'y'=>216), array('x'=>418, 'y'=>186)));
        $this->addTemplate('arrow', array(array('x'=>68, 'y'=>222), array('x'=>70, 'y'=>220), array('x'=>73, 'y'=>218), array('x'=>75, 'y'=>217), array('x'=>77, 'y'=>215), array('x'=>80, 'y'=>213), array('x'=>82, 'y'=>212), array('x'=>84, 'y'=>210), array('x'=>87, 'y'=>209), array('x'=>89, 'y'=>208), array('x'=>92, 'y'=>206), array('x'=>95, 'y'=>204), array('x'=>101, 'y'=>201), array('x'=>106, 'y'=>198), array('x'=>112, 'y'=>194), array('x'=>118, 'y'=>191), array('x'=>124, 'y'=>187), array('x'=>127, 'y'=>186), array('x'=>132, 'y'=>183), array('x'=>138, 'y'=>181), array('x'=>141, 'y'=>180), array('x'=>146, 'y'=>178), array('x'=>154, 'y'=>173), array('x'=>159, 'y'=>171), array('x'=>161, 'y'=>170), array('x'=>166, 'y'=>167), array('x'=>168, 'y'=>167), array('x'=>171, 'y'=>166), array('x'=>174, 'y'=>164), array('x'=>177, 'y'=>162), array('x'=>180, 'y'=>160), array('x'=>182, 'y'=>158), array('x'=>183, 'y'=>156), array('x'=>181, 'y'=>154), array('x'=>178, 'y'=>153), array('x'=>171, 'y'=>153), array('x'=>164, 'y'=>153), array('x'=>160, 'y'=>153), array('x'=>150, 'y'=>154), array('x'=>147, 'y'=>155), array('x'=>141, 'y'=>157), array('x'=>137, 'y'=>158), array('x'=>135, 'y'=>158), array('x'=>137, 'y'=>158), array('x'=>140, 'y'=>157), array('x'=>143, 'y'=>156), array('x'=>151, 'y'=>154), array('x'=>160, 'y'=>152), array('x'=>170, 'y'=>149), array('x'=>179, 'y'=>147), array('x'=>185, 'y'=>145), array('x'=>192, 'y'=>144), array('x'=>196, 'y'=>144), array('x'=>198, 'y'=>144), array('x'=>200, 'y'=>144), array('x'=>201, 'y'=>147), array('x'=>199, 'y'=>149), array('x'=>194, 'y'=>157), array('x'=>191, 'y'=>160), array('x'=>186, 'y'=>167), array('x'=>180, 'y'=>176), array('x'=>177, 'y'=>179), array('x'=>171, 'y'=>187), array('x'=>169, 'y'=>189), array('x'=>165, 'y'=>194), array('x'=>164, 'y'=>196)));
        $this->addTemplate('left square bracket', array(array('x'=>140, 'y'=>124), array('x'=>138, 'y'=>123), array('x'=>135, 'y'=>122), array('x'=>133, 'y'=>123), array('x'=>130, 'y'=>123), array('x'=>128, 'y'=>124), array('x'=>125, 'y'=>125), array('x'=>122, 'y'=>124), array('x'=>120, 'y'=>124), array('x'=>118, 'y'=>124), array('x'=>116, 'y'=>125), array('x'=>113, 'y'=>125), array('x'=>111, 'y'=>125), array('x'=>108, 'y'=>124), array('x'=>106, 'y'=>125), array('x'=>104, 'y'=>125), array('x'=>102, 'y'=>124), array('x'=>100, 'y'=>123), array('x'=>98, 'y'=>123), array('x'=>95, 'y'=>124), array('x'=>93, 'y'=>123), array('x'=>90, 'y'=>124), array('x'=>88, 'y'=>124), array('x'=>85, 'y'=>125), array('x'=>83, 'y'=>126), array('x'=>81, 'y'=>127), array('x'=>81, 'y'=>129), array('x'=>82, 'y'=>131), array('x'=>82, 'y'=>134), array('x'=>83, 'y'=>138), array('x'=>84, 'y'=>141), array('x'=>84, 'y'=>144), array('x'=>85, 'y'=>148), array('x'=>85, 'y'=>151), array('x'=>86, 'y'=>156), array('x'=>86, 'y'=>160), array('x'=>86, 'y'=>164), array('x'=>86, 'y'=>168), array('x'=>87, 'y'=>171), array('x'=>87, 'y'=>175), array('x'=>87, 'y'=>179), array('x'=>87, 'y'=>182), array('x'=>87, 'y'=>186), array('x'=>88, 'y'=>188), array('x'=>88, 'y'=>195), array('x'=>88, 'y'=>198), array('x'=>88, 'y'=>201), array('x'=>88, 'y'=>207), array('x'=>89, 'y'=>211), array('x'=>89, 'y'=>213), array('x'=>89, 'y'=>217), array('x'=>89, 'y'=>222), array('x'=>88, 'y'=>225), array('x'=>88, 'y'=>229), array('x'=>88, 'y'=>231), array('x'=>88, 'y'=>233), array('x'=>88, 'y'=>235), array('x'=>89, 'y'=>237), array('x'=>89, 'y'=>240), array('x'=>89, 'y'=>242), array('x'=>91, 'y'=>241), array('x'=>94, 'y'=>241), array('x'=>96, 'y'=>240), array('x'=>98, 'y'=>239), array('x'=>105, 'y'=>240), array('x'=>109, 'y'=>240), array('x'=>113, 'y'=>239), array('x'=>116, 'y'=>240), array('x'=>121, 'y'=>239), array('x'=>130, 'y'=>240), array('x'=>136, 'y'=>237), array('x'=>139, 'y'=>237), array('x'=>144, 'y'=>238), array('x'=>151, 'y'=>237), array('x'=>157, 'y'=>236), array('x'=>159, 'y'=>237)));
        $this->addTemplate('right square bracket', array(array('x'=>112, 'y'=>138), array('x'=>112, 'y'=>136), array('x'=>115, 'y'=>136), array('x'=>118, 'y'=>137), array('x'=>120, 'y'=>136), array('x'=>123, 'y'=>136), array('x'=>125, 'y'=>136), array('x'=>128, 'y'=>136), array('x'=>131, 'y'=>136), array('x'=>134, 'y'=>135), array('x'=>137, 'y'=>135), array('x'=>140, 'y'=>134), array('x'=>143, 'y'=>133), array('x'=>145, 'y'=>132), array('x'=>147, 'y'=>132), array('x'=>149, 'y'=>132), array('x'=>152, 'y'=>132), array('x'=>153, 'y'=>134), array('x'=>154, 'y'=>137), array('x'=>155, 'y'=>141), array('x'=>156, 'y'=>144), array('x'=>157, 'y'=>152), array('x'=>158, 'y'=>161), array('x'=>160, 'y'=>170), array('x'=>162, 'y'=>182), array('x'=>164, 'y'=>192), array('x'=>166, 'y'=>200), array('x'=>167, 'y'=>209), array('x'=>168, 'y'=>214), array('x'=>168, 'y'=>216), array('x'=>169, 'y'=>221), array('x'=>169, 'y'=>223), array('x'=>169, 'y'=>228), array('x'=>169, 'y'=>231), array('x'=>166, 'y'=>233), array('x'=>164, 'y'=>234), array('x'=>161, 'y'=>235), array('x'=>155, 'y'=>236), array('x'=>147, 'y'=>235), array('x'=>140, 'y'=>233), array('x'=>131, 'y'=>233), array('x'=>124, 'y'=>233), array('x'=>117, 'y'=>235), array('x'=>114, 'y'=>238), array('x'=>112, 'y'=>238)));
        $this->addTemplate('v', array(array('x'=>89, 'y'=>164), array('x'=>90, 'y'=>162), array('x'=>92, 'y'=>162), array('x'=>94, 'y'=>164), array('x'=>95, 'y'=>166), array('x'=>96, 'y'=>169), array('x'=>97, 'y'=>171), array('x'=>99, 'y'=>175), array('x'=>101, 'y'=>178), array('x'=>103, 'y'=>182), array('x'=>106, 'y'=>189), array('x'=>108, 'y'=>194), array('x'=>111, 'y'=>199), array('x'=>114, 'y'=>204), array('x'=>117, 'y'=>209), array('x'=>119, 'y'=>214), array('x'=>122, 'y'=>218), array('x'=>124, 'y'=>222), array('x'=>126, 'y'=>225), array('x'=>128, 'y'=>228), array('x'=>130, 'y'=>229), array('x'=>133, 'y'=>233), array('x'=>134, 'y'=>236), array('x'=>136, 'y'=>239), array('x'=>138, 'y'=>240), array('x'=>139, 'y'=>242), array('x'=>140, 'y'=>244), array('x'=>142, 'y'=>242), array('x'=>142, 'y'=>240), array('x'=>142, 'y'=>237), array('x'=>143, 'y'=>235), array('x'=>143, 'y'=>233), array('x'=>145, 'y'=>229), array('x'=>146, 'y'=>226), array('x'=>148, 'y'=>217), array('x'=>149, 'y'=>208), array('x'=>149, 'y'=>205), array('x'=>151, 'y'=>196), array('x'=>151, 'y'=>193), array('x'=>153, 'y'=>182), array('x'=>155, 'y'=>172), array('x'=>157, 'y'=>165), array('x'=>159, 'y'=>160), array('x'=>162, 'y'=>155), array('x'=>164, 'y'=>150), array('x'=>165, 'y'=>148), array('x'=>166, 'y'=>146)));
        $this->addTemplate('delete', array(array('x'=>123, 'y'=>129), array('x'=>123, 'y'=>131), array('x'=>124, 'y'=>133), array('x'=>125, 'y'=>136), array('x'=>127, 'y'=>140), array('x'=>129, 'y'=>142), array('x'=>133, 'y'=>148), array('x'=>137, 'y'=>154), array('x'=>143, 'y'=>158), array('x'=>145, 'y'=>161), array('x'=>148, 'y'=>164), array('x'=>153, 'y'=>170), array('x'=>158, 'y'=>176), array('x'=>160, 'y'=>178), array('x'=>164, 'y'=>183), array('x'=>168, 'y'=>188), array('x'=>171, 'y'=>191), array('x'=>175, 'y'=>196), array('x'=>178, 'y'=>200), array('x'=>180, 'y'=>202), array('x'=>181, 'y'=>205), array('x'=>184, 'y'=>208), array('x'=>186, 'y'=>210), array('x'=>187, 'y'=>213), array('x'=>188, 'y'=>215), array('x'=>186, 'y'=>212), array('x'=>183, 'y'=>211), array('x'=>177, 'y'=>208), array('x'=>169, 'y'=>206), array('x'=>162, 'y'=>205), array('x'=>154, 'y'=>207), array('x'=>145, 'y'=>209), array('x'=>137, 'y'=>210), array('x'=>129, 'y'=>214), array('x'=>122, 'y'=>217), array('x'=>118, 'y'=>218), array('x'=>111, 'y'=>221), array('x'=>109, 'y'=>222), array('x'=>110, 'y'=>219), array('x'=>112, 'y'=>217), array('x'=>118, 'y'=>209), array('x'=>120, 'y'=>207), array('x'=>128, 'y'=>196), array('x'=>135, 'y'=>187), array('x'=>138, 'y'=>183), array('x'=>148, 'y'=>167), array('x'=>157, 'y'=>153), array('x'=>163, 'y'=>145), array('x'=>165, 'y'=>142), array('x'=>172, 'y'=>133), array('x'=>177, 'y'=>127), array('x'=>179, 'y'=>127), array('x'=>180, 'y'=>125)));
        $this->addTemplate('left curly brace', array(array('x'=>150, 'y'=>116), array('x'=>147, 'y'=>117), array('x'=>145, 'y'=>116), array('x'=>142, 'y'=>116), array('x'=>139, 'y'=>117), array('x'=>136, 'y'=>117), array('x'=>133, 'y'=>118), array('x'=>129, 'y'=>121), array('x'=>126, 'y'=>122), array('x'=>123, 'y'=>123), array('x'=>120, 'y'=>125), array('x'=>118, 'y'=>127), array('x'=>115, 'y'=>128), array('x'=>113, 'y'=>129), array('x'=>112, 'y'=>131), array('x'=>113, 'y'=>134), array('x'=>115, 'y'=>134), array('x'=>117, 'y'=>135), array('x'=>120, 'y'=>135), array('x'=>123, 'y'=>137), array('x'=>126, 'y'=>138), array('x'=>129, 'y'=>140), array('x'=>135, 'y'=>143), array('x'=>137, 'y'=>144), array('x'=>139, 'y'=>147), array('x'=>141, 'y'=>149), array('x'=>140, 'y'=>152), array('x'=>139, 'y'=>155), array('x'=>134, 'y'=>159), array('x'=>131, 'y'=>161), array('x'=>124, 'y'=>166), array('x'=>121, 'y'=>166), array('x'=>117, 'y'=>166), array('x'=>114, 'y'=>167), array('x'=>112, 'y'=>166), array('x'=>114, 'y'=>164), array('x'=>116, 'y'=>163), array('x'=>118, 'y'=>163), array('x'=>120, 'y'=>162), array('x'=>122, 'y'=>163), array('x'=>125, 'y'=>164), array('x'=>127, 'y'=>165), array('x'=>129, 'y'=>166), array('x'=>130, 'y'=>168), array('x'=>129, 'y'=>171), array('x'=>127, 'y'=>175), array('x'=>125, 'y'=>179), array('x'=>123, 'y'=>184), array('x'=>121, 'y'=>190), array('x'=>120, 'y'=>194), array('x'=>119, 'y'=>199), array('x'=>120, 'y'=>202), array('x'=>123, 'y'=>207), array('x'=>127, 'y'=>211), array('x'=>133, 'y'=>215), array('x'=>142, 'y'=>219), array('x'=>148, 'y'=>220), array('x'=>151, 'y'=>221)));
        $this->addTemplate('star', array(array('x'=>75, 'y'=>250), array('x'=>75, 'y'=>247), array('x'=>77, 'y'=>244), array('x'=>78, 'y'=>242), array('x'=>79, 'y'=>239), array('x'=>80, 'y'=>237), array('x'=>82, 'y'=>234), array('x'=>82, 'y'=>232), array('x'=>84, 'y'=>229), array('x'=>85, 'y'=>225), array('x'=>87, 'y'=>222), array('x'=>88, 'y'=>219), array('x'=>89, 'y'=>216), array('x'=>91, 'y'=>212), array('x'=>92, 'y'=>208), array('x'=>94, 'y'=>204), array('x'=>95, 'y'=>201), array('x'=>96, 'y'=>196), array('x'=>97, 'y'=>194), array('x'=>98, 'y'=>191), array('x'=>100, 'y'=>185), array('x'=>102, 'y'=>178), array('x'=>104, 'y'=>173), array('x'=>104, 'y'=>171), array('x'=>105, 'y'=>164), array('x'=>106, 'y'=>158), array('x'=>107, 'y'=>156), array('x'=>107, 'y'=>152), array('x'=>108, 'y'=>145), array('x'=>109, 'y'=>141), array('x'=>110, 'y'=>139), array('x'=>112, 'y'=>133), array('x'=>113, 'y'=>131), array('x'=>116, 'y'=>127), array('x'=>117, 'y'=>125), array('x'=>119, 'y'=>122), array('x'=>121, 'y'=>121), array('x'=>123, 'y'=>120), array('x'=>125, 'y'=>122), array('x'=>125, 'y'=>125), array('x'=>127, 'y'=>130), array('x'=>128, 'y'=>133), array('x'=>131, 'y'=>143), array('x'=>136, 'y'=>153), array('x'=>140, 'y'=>163), array('x'=>144, 'y'=>172), array('x'=>145, 'y'=>175), array('x'=>151, 'y'=>189), array('x'=>156, 'y'=>201), array('x'=>161, 'y'=>213), array('x'=>166, 'y'=>225), array('x'=>169, 'y'=>233), array('x'=>171, 'y'=>236), array('x'=>174, 'y'=>243), array('x'=>177, 'y'=>247), array('x'=>178, 'y'=>249), array('x'=>179, 'y'=>251), array('x'=>180, 'y'=>253), array('x'=>180, 'y'=>255), array('x'=>179, 'y'=>257), array('x'=>177, 'y'=>257), array('x'=>174, 'y'=>255), array('x'=>169, 'y'=>250), array('x'=>164, 'y'=>247), array('x'=>160, 'y'=>245), array('x'=>149, 'y'=>238), array('x'=>138, 'y'=>230), array('x'=>127, 'y'=>221), array('x'=>124, 'y'=>220), array('x'=>112, 'y'=>212), array('x'=>110, 'y'=>210), array('x'=>96, 'y'=>201), array('x'=>84, 'y'=>195), array('x'=>74, 'y'=>190), array('x'=>64, 'y'=>182), array('x'=>55, 'y'=>175), array('x'=>51, 'y'=>172), array('x'=>49, 'y'=>170), array('x'=>51, 'y'=>169), array('x'=>56, 'y'=>169), array('x'=>66, 'y'=>169), array('x'=>78, 'y'=>168), array('x'=>92, 'y'=>166), array('x'=>107, 'y'=>164), array('x'=>123, 'y'=>161), array('x'=>140, 'y'=>162), array('x'=>156, 'y'=>162), array('x'=>171, 'y'=>160), array('x'=>173, 'y'=>160), array('x'=>186, 'y'=>160), array('x'=>195, 'y'=>160), array('x'=>198, 'y'=>161), array('x'=>203, 'y'=>163), array('x'=>208, 'y'=>163), array('x'=>206, 'y'=>164), array('x'=>200, 'y'=>167), array('x'=>187, 'y'=>172), array('x'=>174, 'y'=>179), array('x'=>172, 'y'=>181), array('x'=>153, 'y'=>192), array('x'=>137, 'y'=>201), array('x'=>123, 'y'=>211), array('x'=>112, 'y'=>220), array('x'=>99, 'y'=>229), array('x'=>90, 'y'=>237), array('x'=>80, 'y'=>244), array('x'=>73, 'y'=>250), array('x'=>69, 'y'=>254), array('x'=>69, 'y'=>252)));
        $this->addTemplate('pigtail', array(array('x'=>81, 'y'=>219), array('x'=>84, 'y'=>218), array('x'=>86, 'y'=>220), array('x'=>88, 'y'=>220), array('x'=>90, 'y'=>220), array('x'=>92, 'y'=>219), array('x'=>95, 'y'=>220), array('x'=>97, 'y'=>219), array('x'=>99, 'y'=>220), array('x'=>102, 'y'=>218), array('x'=>105, 'y'=>217), array('x'=>107, 'y'=>216), array('x'=>110, 'y'=>216), array('x'=>113, 'y'=>214), array('x'=>116, 'y'=>212), array('x'=>118, 'y'=>210), array('x'=>121, 'y'=>208), array('x'=>124, 'y'=>205), array('x'=>126, 'y'=>202), array('x'=>129, 'y'=>199), array('x'=>132, 'y'=>196), array('x'=>136, 'y'=>191), array('x'=>139, 'y'=>187), array('x'=>142, 'y'=>182), array('x'=>144, 'y'=>179), array('x'=>146, 'y'=>174), array('x'=>148, 'y'=>170), array('x'=>149, 'y'=>168), array('x'=>151, 'y'=>162), array('x'=>152, 'y'=>160), array('x'=>152, 'y'=>157), array('x'=>152, 'y'=>155), array('x'=>152, 'y'=>151), array('x'=>152, 'y'=>149), array('x'=>152, 'y'=>146), array('x'=>149, 'y'=>142), array('x'=>148, 'y'=>139), array('x'=>145, 'y'=>137), array('x'=>141, 'y'=>135), array('x'=>139, 'y'=>135), array('x'=>134, 'y'=>136), array('x'=>130, 'y'=>140), array('x'=>128, 'y'=>142), array('x'=>126, 'y'=>145), array('x'=>122, 'y'=>150), array('x'=>119, 'y'=>158), array('x'=>117, 'y'=>163), array('x'=>115, 'y'=>170), array('x'=>114, 'y'=>175), array('x'=>117, 'y'=>184), array('x'=>120, 'y'=>190), array('x'=>125, 'y'=>199), array('x'=>129, 'y'=>203), array('x'=>133, 'y'=>208), array('x'=>138, 'y'=>213), array('x'=>145, 'y'=>215), array('x'=>155, 'y'=>218), array('x'=>164, 'y'=>219), array('x'=>166, 'y'=>219), array('x'=>177, 'y'=>219), array('x'=>182, 'y'=>218), array('x'=>192, 'y'=>216), array('x'=>196, 'y'=>213), array('x'=>199, 'y'=>212), array('x'=>201, 'y'=>211)));
		*/
    }
    
    /**
     * Recognizes given stroke
     * 
     * @param array $pointsArray Stroke array with points to recognize
     * @return array Returns array with two keys: 'strokeName' - recognized stroke and 'templScore' - strokes similarity score 
     */
    public function recognizeStroke($pointsArray){
    	// $result = array();
		
        $bestFit = INF;
        $t = 0;
        
        $pointsArray = $this->_resampleTemplate($pointsArray, $this->_numPoints);
        $radiansNum = $this->_indicativeAngle($pointsArray);
        $pointsArray = $this->_rotateBy($pointsArray, $radiansNum);
        $pointsArray = $this->_scaleTo($pointsArray, $this->_squareSize);
        $pointsArray = $this->_translateTo($pointsArray, $this->_originPoint);
        $strokeVector = $this->_vectorizeStroke($pointsArray);
		        
        $templatesCount=count($this->_templatesArray);
        for($i = 0; $i < $templatesCount; $i++){
            $distance = $this->_optimalCosineDistance($this->_templatesArray[$i]['templVector'], $strokeVector);

			// $result[] = array('strokeName' => $this->_templatesArray[$i]['templName'], 'strokeScore' =>  1.0 / $distance);
            
            if($distance < $bestFit){
                $bestFit = $distance;
                $t = $i;    // Which template fits best
            }
        }
		
        return array(
        				'strokeName' => $this->_templatesArray[$t]['templName'],
        				'strokeScore' =>  1.0 / $bestFit,
					);
    }
    
    /**
     * Adds stroke template
     * 
     * @param string $templName Name of template
     * @param array $pointsArray Array with points of template
     */
    public function addTemplate($templName, $pointsArray){
        $pointsArray = $this->_resampleTemplate($pointsArray, $this->_numPoints);
        $radiansNum = $this->_indicativeAngle($pointsArray);
        $pointsArray = $this->_rotateBy($pointsArray, $radiansNum);
        $pointsArray = $this->_scaleTo($pointsArray, $this->_squareSize);
        $pointsArray = $this->_translateTo($pointsArray, $this->_originPoint);
        $strokeVector = $this->_vectorizeStroke($pointsArray);
        
        $this->_templatesArray[] = array(
            'templName'      =>  $templName,
            'templPoints'    =>  $pointsArray,
            'templVector'    =>  $strokeVector
        );
		
		//var_export($this->_templatesArray);
    }
    
    /**
     * Creates and returns single point array
     * 
     * @param int $x X coordinate
     * @param int $y Y coordinate
     * @return array Single point array
     */
    private function _newPoint($x, $y){
        return array('x' => $x, 'y' => $y);
    }
    
    /**
     * Creates and returns rectangle array
     * 
     * @param int $x X coordinate
     * @param int $y Y coordinate
     * @param int $width Rectangle width
     * @param int $height Rectangle height
     * @return array Rectangle array
     */
    private function _newRectangle($x, $y, $width, $height){
        return array('x' => $x, 'y' => $y, 'width' => $width, 'height' => $height);
    }
    
    
    /**
     *  Resamples template to given amount of points(?)
     * 
     * @param array $pointsArray Array with points
     * @param init $numPoints Number of points
     * @return array Resampled array of points
     */
    private function _resampleTemplate($pointsArray, $numPoints){
        $intervalLenght = $this->_pathLenght($pointsArray) / ($numPoints - 1);
        $D = 0.0; // What the Hell is That?!
        $newPointsArr = array($pointsArray[0]);

        for($i = 1; $i < count($pointsArray); $i++){
            
            $pointsDistance = $this->_calcDistance($pointsArray[$i - 1], $pointsArray[$i]);

            if(($D + $pointsDistance) >= $intervalLenght){
                $qX = $pointsArray[$i - 1]['x'] + (($intervalLenght - $D) / $pointsDistance) * ($pointsArray[$i]['x'] - $pointsArray[$i - 1]['x']);
                $qY = $pointsArray[$i - 1]['y'] + (($intervalLenght - $D) / $pointsDistance) * ($pointsArray[$i]['y'] - $pointsArray[$i - 1]['y']);
                $newPoint = $this->_newPoint($qX, $qY);
                $newPointsArr[] = $newPoint;
                array_splice($pointsArray, $i, 0, array($newPoint));    // I hate this function... really. 3h just to wrap $newPoint with array()...
                $D = 0.0;
            }
            else
                $D += $pointsDistance;
        }
        // „somtimes we fall a rounding-error short of adding the last point, so add it if so"
        $newPointsCount = count($newPointsArr);
        if($newPointsCount == $numPoints - 1){
            $newPointsArr[] = $this->_newPoint($pointsArray[count($pointsArray) - 1]['x'], $pointsArray[count($pointsArray) - 1]['y']);
        }
        return $newPointsArr;
    }
    
    
    private function _indicativeAngle($pointsArray){
        $centroid = $this->_centroid($pointsArray);
        return atan2($centroid['y'] - $pointsArray[0]['y'], $centroid['x'] - $pointsArray[0]['x']); 
    }
    
    /**
     * Rotates whole stroke with a given number of radians
     * 
     * @param array $pointsArray Array of points(stroke)
     * @param int $radiansNum Number of radians
     * @return array Rotated array of points(stroke) 
     */
    private function _rotateBy($pointsArray, $radiansNum){
        $centroid = $this->_centroid($pointsArray);
        $cos = cos($radiansNum);
        $sin = sin($radiansNum);
        $newPointsArray = array();
        $pointsArrayCount = count($pointsArray);
        
        for($i = 0; $i < $pointsArrayCount; $i++){
            $qX = ($pointsArray[$i]['x'] - $centroid['x']) * $cos - ($pointsArray[$i]['y'] - $centroid['y']) * $sin + $centroid['x'];
            $qY = ($pointsArray[$i]['x'] - $centroid['x']) * $sin + ($pointsArray[$i]['y'] - $centroid['y']) * $cos + $centroid['y'];
            
            $newPointsArray[] = $this->_newPoint($qX, $qY);
        }
        return $newPointsArray;
    }
    
    
    /**
     * Scales whole stroke to a given size
     * 
     * @param array $pointsArray Array of points(stroke)
     * @param int $size Size of sizing square
     * @return array Scaled array of points(stroke) 
     */
    private function _scaleTo($pointsArray, $size){
        $bBox = $this->_boundingBox($pointsArray);
        $newPointsArray = array();
        $pointsArrayCount = count($pointsArray);
        
        for($i = 0; $i < $pointsArrayCount; $i++){
            $qX = $pointsArray[$i]['x'] * ($size / $bBox['width']);
            $qY = $pointsArray[$i]['y'] * ($size / $bBox['height']);
            $newPointsArray[] = $this->_newPoint($qX, $qY);
        }
        return $newPointsArray;
    }
    
    private function _translateTo($pointsArray, $pointArray){
        $centroid = $this->_centroid($pointsArray);
        $newPointsArray = array();
        $pointsArrayCount = count($pointsArray);
        
        for($i = 0; $i < $pointsArrayCount; $i++){
            $qX = $pointsArray[$i]['x'] + $pointArray['x'] - $centroid['x'];
            $qY = $pointsArray[$i]['y'] + $pointArray['y'] - $centroid['y'];
            $newPointsArray[] = $this->_newPoint($qX, $qY);
        }
        return $newPointsArray;
    }
    
    private function _vectorizeStroke($pointsArray) {    // „for Protractor"
        $pointsSum = 0.0;
        $vectorArray = array();
        $pointsArrayCount = count($pointsArray);
        for($i = 0; $i < $pointsArrayCount; $i++){
            $vectorArray[] = $pointsArray[$i]['x'];
            $vectorArray[] = $pointsArray[$i]['y'];
            $pointsSum += $pointsArray[$i]['x'] * $pointsArray[$i]['x'] + $pointsArray[$i]['y'] * $pointsArray[$i]['y'];
        }
        $magnitude = sqrt($pointsSum);
        
        $vectorArrayCount = count($vectorArray);
        for($i = 0; $i < $vectorArrayCount; $i++){
            $vectorArray[$i] /= $magnitude;
        }

        return $vectorArray;
    }
    
    private function _optimalCosineDistance($vectorOne, $vectorTwo){ // „for Protractor"
        $a = $b = 0.0;  // I've got no idea what are these variables representing :P
        $vectorCount = count($vectorOne);
        for($i = 0; $i < $vectorCount; $i += 2){
            $a += $vectorOne[$i] * $vectorTwo[$i] + $vectorOne[$i + 1] * $vectorTwo[$i + 1];
            $b += $vectorOne[$i] * $vectorTwo[$i + 1] - $vectorOne[$i + 1] * $vectorTwo[$i];
        }
        
        $angle = atan($b / $a);
        
        return acos($a * cos($angle) + $b * sin($angle));
    }
    
    /**
     * Calculates centroid of given stroke
     * 
     * @param array $pointsArray Array of points
     * @return array Centroid point array 
     */
    private function _centroid($pointsArray){
        $x = $y = 0.0;
        $pointsArrayCount = count($pointsArray);
        
        for($i = 0; $i < $pointsArrayCount; $i++){
            $x += $pointsArray[$i]['x'];
            $y += $pointsArray[$i]['y'];
        }
        $x /= $pointsArrayCount;
        $y /= $pointsArrayCount;
        
        return $this->_newPoint($x, $y);
    }
    
    /**
     * Returns bounding box rectangle array
     * 
     * @param array $pointsArray Array of points
     * @return array Rectangle array 
     */
    private function _boundingBox($pointsArray){
        $minX = $minY = INF;
        $maxX = $maxY = -INF;
        $pointsArrayCount = count($pointsArray);
        
        for($i = 0; $i < $pointsArrayCount; $i++){
            if($pointsArray[$i]['x'] < $minX)
                $minX = $pointsArray[$i]['x'];
            if($pointsArray[$i]['x'] > $maxX)
                $maxX = $pointsArray[$i]['x'];
            if($pointsArray[$i]['y'] < $minY)
                $minY = $pointsArray[$i]['y'];
            if($pointsArray[$i]['y'] > $maxY)
                $maxY = $pointsArray[$i]['y'];
        }
        return $this->_newRectangle($minX, $minY, $maxX - $minX, $maxY - $minY);
    }
    
    
    /**
     * Calculates full lenght of stroke
     * 
     * @param array $pointsArray
     */
    private function _pathLenght($pointsArray){
        $pathLenght = 0;
        $pointsArrCount = count($pointsArray);
        
        for($i = 1; $i < $pointsArrCount; $i++){
            $pathLenght += $this->_calcDistance($pointsArray[$i-1], $pointsArray[$i]);
        }
        return $pathLenght;
    }
    
    /**
     * Calculates distance between two points
     * http://upload.wikimedia.org/wikipedia/en/math/f/0/a/f0a4a3d633ef96d31f068e387cd91fc2.png
     * 
     * @param array $pointOne
     * @param array $pointTwo 
     */
    private function _calcDistance($pointOne, $pointTwo){
        $dX = $pointTwo['x'] - $pointOne['x'];
        $dY = $pointTwo['y'] - $pointOne['y'];
        return sqrt($dX * $dX + $dY * $dY);
    } 
}
?>
