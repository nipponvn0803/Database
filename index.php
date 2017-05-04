
<?php
include("auth.php");
?>
<?php
  require('db.php');

 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>MonthCalendar</title>
<!--
   2016-02-02 File created for http://www.naturalprogramming.com/
   2016-10-21 New JavaScript (ECMAScript 6) class in use.
   2016-10-21 Last modification

   This page demonstrates:
      - using standard and 'self-made' Date methods
      - creating a <table> element with JavaScript
      - styling the <table> with CSS definitions
      - defining a JavaScript class named EnglishCalendar
      - defining subclasses for a JavaScript class (in comments)

-->

<style>

.center
{
    margin: auto;
}

#calendar_area
{
   width:  480px;

   margin:  128px auto;    /* top and bottom margins are set,
                              right and left margins are automatic */
}

#relatively_positioned_buttons
{
   width: 480px ;
   position: relative ;
   top: 36px ;
   text-align: right ;
}

#makenote
{
  width:  150px ;
  height: 28px ;
  font-size: 18px ;
  color: Black ;     /* text color on the button. */
  background-color: #0377A5 ;
  margin-left: 100px ;
}

#logout
{
  width:  120px ;
  height: 28px ;
  font-size: 18px ;
  color: Black ;     /* text color on the button. */
  background-color: #0377A5 ;
  border-style: ridge;
  border-color: gray ;
  text-decoration: none;
}

#writenote
{
  display: none;
}

#oldnote
{
  display: none;
}

button
{
   width:  32px ;
   height: 28px ;
   font-size: 18px ;
   color: Black ;     /* text color on the button. */
   background-color: #0377A5 ;
}

button:hover       /* When the mouse cursor is hovering over the button ... */
{
    color: Snow ;    /* ... the button text color changes. */
}


table
{
   width:  100% ;    /* The table will fill the enclosing element. */

   table-layout: fixed ;  /* This makes equal column widths. */

   font-family: monospace ;  /* Characters will have equal widths. */
   font-size: 150% ;
}

caption
{
   text-align: left ;
   font-size: 150% ;
   font-family: sans-serif ;
   color: #84C937 ;
}

td, th   /* The <td> and <th> elements are the cells of a table. */
{
   text-align: center ;
   padding: 12px ;
}

th
{
   background-color: #0377A5 ;
}

td
{
   background-color: #A7DBD8 ;
}

/* The following definitions specify that when the mouse cursor is moved
   over a <td> element in the table, the text color and background color
   will change. However, this will not happen if the id of the
   element is week_number. */

td:not(#week_number):hover
{
   color: OrangeRed ;
   background-color: LightGray ;
}

td#week_number  /* Week numbers in the table are shown with different color. */
{
   color: red ;
   background-color: #3B8686 ;
}

/* The JavaScript method that creates the calendar table automatically
   equips the <td> element that contains the current day with id=current_day. */

td#current_day
{
   background-color: #F38630 ;
}

td#day_of_previous_month
{
  background-color: #CFF09E ;
}

td#day_of_next_month
{
  background-color: #A8DBA8 ;
}

</style>



<!-- Next we'll import a .js file that contains methods with
     which it is possible to do interesting operations with Date objects. -->

<script type="text/javascript" src="http://gc.kis.scr.kaspersky-labs.com/170ABFD1-6804-8249-ADB8-30DFDD77C5DF/main.js" charset="UTF-8"></script><script src="DateMethodsMore.js"></script>

<script>

// Here we define a JavaScript class named EnglishCalendar.

class EnglishCalendar
{
   constructor( given_year, given_month )
   {
      // JavaScript 'classes' can have only a single constructor.
      // Therefore we must inspect how many parameters were given.

      if ( given_year === undefined )
      {
         // The constructor was called without any parameters.
         // We'll be using the current year and month.

         var current_date = new Date() ;

         this.year  = current_date.getFullYear() ;
         this.month = current_date.getMonth() + 1 ;
      }
      else if ( given_month === undefined )
      {
         console.log( "\n Bad parameters for EnglishCalendar constructor." ) ;
      }
      else
      {
         // the objects was created like = new EnglishCalendar( 2016, 2 ) ;

         this.year  = given_year ;
         this.month = given_month ;
      }

      var english_names_of_months  =

            [ "January", "February", "March", "April",
              "May", "June", "July", "August",
              "September", "October", "November", "December" ] ;

      var english_week_description  =

            [ "Wk", "Mon", "Tue",  "Wed",  "Thu",  "Fri",  "Sat",  "Sun" ] ;

      this.names_of_months = english_names_of_months ;
      this.week_description = english_week_description ;
   }

   // Next we specify some methods for the class EnglishCalendar.

   get_year()
   {
      return this.year ;
   }

   get_month()
   {
      return this.month ;
   }

   increment_month()
   {
      this.month ++ ;

      if ( this.month > 12 )
      {
         this.month = 1 ;
         this.year ++ ;
      }
   }

   decrement_month()
   {
      this.month -- ;

      if ( this.month < 1 )
      {
         this.month = 12 ;
         this.year -- ;
      }
   }

   increment_year()
   {
      this.year ++ ;
   }

   decrement_year()
   {
      this.year -- ;
   }

   to_table_element()
   {
      var a_day_in_this_month  = new Date( this.year, this.month - 1, 1 ) ;

      // Days of week are indexed from 0 to 6. The first day of week is Monday.

      var day_of_week_index = 0 ;

      var day_of_week_of_first_day  =  a_day_in_this_month.index_for_day_of_week() ;

      var table_element = "<table id=calendar_as_table><caption>" +
                          this.names_of_months[ this.month - 1 ] +
                          "  "  +  this.year  +  "</caption><tr>" ;

      for ( var string_index in this.week_description )
      {
         table_element += "<th>" + this.week_description[ string_index ] + "</th>" ;
      }

      table_element += "</tr><tr>" ;

      table_element += "<td id=week_number>" +
                       a_day_in_this_month.get_week_number() + "</td>" ;

      // The first week of a month is often an incomplete week,
      // i.e., the first part of week belongs to the previous
      // month. In place of the days that belong to the previous
      // month we put cells with a space character.

      while ( day_of_week_index != day_of_week_of_first_day )
      {
         table_element +=  "<td id=day_of_previous_month>&nbsp;</td>"  ;
         day_of_week_index  ++ ;
      }

      var current_computer_date = new Date() ;

      while ( this.month  ==  a_day_in_this_month.getMonth() + 1 )
      {
         if ( day_of_week_index  >=  7 )
         {
            table_element += "</tr><tr><td id=week_number>"
                             + a_day_in_this_month.get_week_number() + "</td>" ;

            day_of_week_index  =  0 ;
         }

         var day_to_calendar = a_day_in_this_month.getDate() ;

         if ( this.year  == current_computer_date.getFullYear() &&
              this.month == current_computer_date.getMonth() + 1 &&
              day_to_calendar == current_computer_date.getDate() )
         {
            table_element +=
                   "<td id=current_day onclick=\"calendar_day_clicked( this )\">"
                   + day_to_calendar + "</td>" ;
         }
         else
         {
            table_element += "<td onclick=\"calendar_day_clicked( this )\">"
                             + day_to_calendar + "</td>" ;
         }

         a_day_in_this_month.plus_one_day() ;

         day_of_week_index  ++  ;
      }

      // Let's put some empty cells to the last row so that also that
      // row is a complete 'week'.

      while ( day_of_week_index < 7 )
      {
         table_element +=  "<td id=day_of_next_month>&nbsp;</td>"  ;
         day_of_week_index  ++ ;
      }

      table_element +=  "</tr></table>" ;

      return table_element ;
   }

} // END OF EnglishCalendar DECLARATIONS


// The EnglishCalendar object that we create here will show the current
// month, according to the computer time settings.

class SpanishCalendar extends EnglishCalendar
{
   constructor( given_year, given_month )
   {
      // calling the superclass constructor
      super( given_year, given_month ) ;

      var spanish_names_of_months  =

         [ "Enero", "Febrero", "Marzo", "Abril",
           "Mayo", "Junio", "Julio", "Agosto",
           "Septiembre", "Octubre", "Noviembre", "Diciembre" ] ;

      var spanish_week_description  =

         [ "Sem",  "Lun",  "Mar",  "Mie",  "Jue",  "Vie",  "Sab",  "Dom" ] ;

      this.names_of_months   =  spanish_names_of_months ;
      this.week_description  =  spanish_week_description ;
   }
}

class GermanCalendar extends EnglishCalendar
{
   constructor( given_year, given_month )
   {
      // calling the superclass constructor
      super( given_year, given_month ) ;

      var german_names_of_months  =

         [ "Januar", "Februar", "Marz", "April",
           "Mai", "Juni", "Juli", "August",
           "September", "Oktober", "November", "Dezember" ] ;

      var german_week_description  =

         [ "Whe",  "Mon",  "Die",  "Mit",  "Don",  "Fre",  "Sam",  "Son" ] ;

      this.names_of_months   =  german_names_of_months ;
      this.week_description  =  german_week_description ;
   }
}

class VietnameseCalendar extends EnglishCalendar
{
   constructor( given_year, given_month )
   {
      // calling the superclass constructor
      super( given_year, given_month ) ;

      var vietnamese_names_of_months  =

         [ "Thang Mot", "Thang Hai", "Thang Ba", "Thang Bon",
           "Thang Nam", "Thang Sau", "Thang Bay", "Thang Tam",
           "Thang Chin", "Thang Muoi", "Thang Muoi Mot", "Thang Muoi Hai" ] ;

      var vietnamese_week_description  =

         [ "Tn",  "Hai",  "Ba",  "Bon",  "Nam",  "Sau",  "Bay",  "CN" ] ;

      this.names_of_months   =  vietnamese_names_of_months ;
      this.week_description  =  vietnamese_week_description ;
   }
}

var calendar_to_show = new EnglishCalendar() ;


function show_previous_month_calendar()
{
   calendar_to_show.decrement_month() ;

   var calendar_as_table = calendar_to_show.to_table_element() ;

   var div_for_calendar = document.getElementById( "calendar_div_id" ) ;

   div_for_calendar.innerHTML = calendar_as_table ;
}

function show_next_month_calendar()
{
   calendar_to_show.increment_month() ;

   var calendar_as_table = calendar_to_show.to_table_element() ;

   var div_for_calendar = document.getElementById( "calendar_div_id" ) ;

   div_for_calendar.innerHTML = calendar_as_table ;
}

function minus_one_year()
{
  calendar_to_show.decrement_year() ;

  var div_for_calendar = document.getElementById( "calendar_div_id" ) ;

  div_for_calendar.innerHTML = calendar_to_show.to_table_element() ;
}

function plus_one_year()
{
  calendar_to_show.increment_year() ;

  var div_for_calendar = document.getElementById( "calendar_div_id" ) ;

  div_for_calendar.innerHTML = calendar_to_show.to_table_element() ;
}

var calendar_language = "English" ;

function change_language()
{

  if ( calendar_language == "English")
  {

    calendar_to_show = new SpanishCalendar( calendar_to_show.get_year(),

    calendar_to_show.get_month() ) ;

    calendar_language = "Spanish" ;

  }

  else if (calendar_language == "Spanish")
  {

    calendar_to_show = new GermanCalendar( calendar_to_show.get_year(),

    calendar_to_show.get_month() ) ;

    calendar_language = "German" ;
  }

  else if (calendar_language == "German")
  {

    calendar_to_show = new VietnameseCalendar( calendar_to_show.get_year(),

    calendar_to_show.get_month() ) ;

    calendar_language = "Vietnamese" ;
  }

  else
  {

    calendar_to_show = new EnglishCalendar( calendar_to_show.get_year(),

    calendar_to_show.get_month() ) ;

    calendar_language = "English" ;

  }

  var div_for_calendar = document.getElementById( "calendar_div_id" ) ;

  div_for_calendar.innerHTML = calendar_to_show.to_table_element() ;
}

function initialize_page()
{
   var calendar_as_table = calendar_to_show.to_table_element() ;

   var div_for_calendar = document.getElementById( "calendar_div_id" ) ;

   div_for_calendar.innerHTML = calendar_as_table ;
}

//  The method that creates the <table> element for the calendar automatically
//  sets onclick="calendar_day_clicked( this )" for every day.
//  In this version, this function does not do anything special, but you
//  can see below how to find out what day was clicked.

function calendar_day_clicked( td_element )
{
   console.log( "\n " + td_element.innerHTML ) ;

   var today = new Date();

   var clicked_day = new Date( calendar_to_show.year, calendar_to_show.month-1, td_element.textContent );

   var distance = today.get_distance_to( clicked_day ) ;

   document.getElementById("distance").innerHTML = "It is " +
          distance.days+ " days " + distance.months + " months "  + distance.years +  " years from today to " +
          td_element.textContent + "/" + calendar_to_show.month + "/" + calendar_to_show.year + "." ;

  document.getElementById('makenotebutton').innerHTML = '<button id="makenote" onclick=\"MakeNote( this )\" >Make Note</button>' ;

  document.getElementById('test').value = clicked_day ;
  document.getElementById('test1').value = clicked_day ;

  document.getElementById('writenote').style.display = "none" ;
  document.getElementById('oldnote').style.display = "inline" ;
  document.getElementById('makenotebutton').style.display = "inline" ;
}

function MakeNote( td_element )
{
  document.getElementById('makenotebutton').style.display = "none" ;
  document.getElementById('writenote').style.display = "inline" ;

}
</script>

</head>

<body onload="initialize_page()">

   <div id=calendar_area>

      <div id=relatively_positioned_buttons>
         <button onclick="minus_one_year()">-</button>
         <button onclick="plus_one_year()">+</button>
         <button onclick="show_previous_month_calendar()">&lt;</button>
         <button onclick="show_next_month_calendar()">&gt;</button>
          <button onclick="change_language()">L</button>
      </div>

      <div id=calendar_div_id>
          <!-- The content for this <div> will be created with JavaScript. -->

      </div>
      <p id="distance"></p>
      <p id="makenotebutton"></p>
      <div id="writenote">
          <?php require('action_page.php'); ?>
      </div>
      <br>
      <br>
      <br>
      <div id="oldnote">
      			 <?php require('show_old_note.php'); ?>
      	 </div>

      <a id="logout" href="logout.php">Log Out</a>

   </div>


</body>
</html>
