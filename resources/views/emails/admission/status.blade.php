<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter"
      rel="stylesheet"
    />
    <style>
      * {
        font-family: "Inter";
      }
      body {
        background-color: rgb(227, 228, 255);
        justify-content: center;
        padding: 50px 5%;
      }
      a {
        text-decoration: none; 
        color: #3f51b5; 
        /* font-weight: bold; */
      }
      .title {
        font-size: 30px;
      }
      .text-center {
        text-align: center;
      }
      .sheet {
        background-color: white;
        margin: 50px auto;
        padding: 80px 10%;
        border-radius: 10px;
        text-align: center;
        max-width: 300px;

      }
      .pill {
        border-radius: 10px;
        padding: 10px;
        margin: 10px auto;
        max-width: 250px;
        word-wrap: break-word
      }
      .image {
        transition: opacity .4s cubic-bezier(.4,0,.2,1);
        background-size: cover;
        background-position: center center;
        max-width: 150px;
        margin-bottom: 50px;
      }
      footer div {
        margin-top: 3px
      }
      @media (max-width: 400px) {
        .title {
          font-size: 25px;
        }
      }
    </style>
  </head>
  <body>

    <div class="text-center">
      <div class="title">Good day <span style="text-transform: capitalize;"><strong>{{$mailData['name']}}!</strong></span></div>
      <div style="padding: 10px">We have an update for your enrollment status!</div>
    </div>

    <div class="sheet">

      <img src="data:image/svg+xml;base64,CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeG1sbnM6c3ZnanM9Imh0dHA6Ly9zdmdqcy5jb20vc3ZnanMiIHZlcnNpb249IjEuMSIgd2lkdGg9IjUxMiIgaGVpZ2h0PSI1MTIiIHg9IjAiIHk9IjAiIHZpZXdCb3g9IjAgMCA1MTIuMDAwMDEgNTEyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiBjbGFzcz0iIj48Zz48cGF0aCB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGQ9Im0xMjYuNjA1NDY5IDIxMC4yOTI5NjkgNjAgMTAzLjkyMTg3NWMtMjcuMjM4MjgxIDE1LjcyNjU2Mi01OC44OTA2MjUgMzQtODYuNjAxNTYzIDUwLTI4LjY5OTIxOCAxNi41NzAzMTItNjUuMzkwNjI1IDYuNzQyMTg3LTgxLjk2MDkzNy0yMS45NjA5MzgtMTYuNDY4NzUtMjguNTAzOTA2LTYuOTE3OTY5LTY1LjI5Mjk2OCAyMS45NjA5MzctODEuOTYwOTM3em0wIDAiIGZpbGw9IiM2ZjdjY2QiIGRhdGEtb3JpZ2luYWw9IiMyYmJkYzQiIHN0eWxlPSIiIGNsYXNzPSIiLz48cGF0aCB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGQ9Im00MDkuNDU3MDMxIDI0My44MTY0MDZjNy41ODk4NDQgMTMuMTM2NzE5LTEuNjYwMTU2IDI5LjYxNzE4OC0xNi44MzIwMzEgMjkuOTg4MjgybC0xMS4yNSAyLjIxMDkzNy0uMjUtMS4yNjk1MzEtMTI4LjczMDQ2OS0yMjIuOTcyNjU2LS44Mzk4NDMtLjY2MDE1NyA3LjE5OTIxOC05LjE3MTg3NWM3LjkxMDE1Ni0xMi45NTcwMzEgMjYuODAwNzgyLTEyLjczODI4MSAzNC4zOTA2MjUuNDEwMTU2IDE5OS43OTI5NjkgMzQ2LjAzMTI1LTUyLjI2MTcxOS05MC41MjczNDMgMTE2LjMxMjUgMjAxLjQ2NDg0NHptMCAwIiBmaWxsPSIjNmY3Y2NkIiBkYXRhLW9yaWdpbmFsPSIjMmJiZGM0IiBzdHlsZT0iIiBjbGFzcz0iIi8+PHBhdGggeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBkPSJtMjA2Ljk2NDg0NCA0MjkuNDg4MjgxYzguMjg5MDYyIDE0LjMzOTg0NCAzLjM3MTA5NCAzMi42ODc1LTEwLjk4MDQ2OSA0MC45NzY1NjMtMTQuMzI4MTI1IDguMjg5MDYyLTMyLjcxMDkzNyAzLjM1NTQ2OC00MC45ODA0NjktMTAuOTc2NTYzbC01NS05NS4yNzM0MzcgNTEuOTYwOTM4LTMwYy40NzY1NjIuODI4MTI1IDU0LjkxNzk2OCA5NS4xMjg5MDYgNTUgOTUuMjczNDM3em0wIDAiIGZpbGw9IiM2ZjdjY2QiIGRhdGEtb3JpZ2luYWw9IiM0OTVkODUiIHN0eWxlPSIiIGNsYXNzPSIiLz48cGF0aCB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGQ9Im0zNzcuNzc3MzQ0IDEwOC45MzM1OTQgMjAgMzQuNjQwNjI1LTI0LjY0MDYyNSAzNy4zMjAzMTItNDAtNjkuMjgxMjV6bTAgMCIgZmlsbD0iI2ZmZmZmZiIgZGF0YS1vcmlnaW5hbD0iI2U5ZWVmMCIgc3R5bGU9IiIgY2xhc3M9IiIvPjxwYXRoIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgZD0ibTM4MS4xMjUgMjc0Ljc0NjA5NC4yNSAxLjI2OTUzMS0xOTQuNzY5NTMxIDM4LjE5OTIxOS02MC0xMDMuOTIxODc1IDEyNC45NDkyMTktMTU5LjE3OTY4OC44Mzk4NDMuNjYwMTU3em0wIDAiIGZpbGw9IiM5YjhjY2MiIGRhdGEtb3JpZ2luYWw9IiNhZGYzZmYiIHN0eWxlPSIiIGNsYXNzPSIiLz48cGF0aCB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGQ9Im0xMzYuOTY0ODQ0IDMwOC4yMzQzNzVjNC43ODEyNS0yLjc1NzgxMyA2LjQxNzk2OC04Ljg3ODkwNiAzLjY2MDE1Ni0xMy42NjAxNTYtMi43NjE3MTktNC43NzczNDQtOC44Nzg5MDYtNi40MTc5NjktMTMuNjYwMTU2LTMuNjYwMTU3LTQuNzgxMjUgMi43NjE3MTktNi40MjE4NzUgOC44ODI4MTMtMy42NjAxNTYgMTMuNjYwMTU3IDIuNzU3ODEyIDQuNzgxMjUgOC44Nzg5MDYgNi40MjE4NzUgMTMuNjYwMTU2IDMuNjYwMTU2em0wIDAiIGZpbGw9IiMxZTA0NzEiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIHN0eWxlPSIiIGNsYXNzPSIiLz48cGF0aCB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGQ9Im05NS45ODQzNzUgMzc3LjI1MzkwNiA1MC4zNTkzNzUgODcuMjMwNDY5YzEwLjg2NzE4OCAxOC44NDM3NSAzNS4zMTI1IDI1LjgyMDMxMyA1NC42NDQ1MzEgMTQuNjQ0NTMxIDE5LjEyODkwNy0xMS4wNTQ2ODcgMjUuNzAzMTI1LTM1LjQ5NjA5NCAxNC42MzY3MTktNTQuNjQwNjI1bC0zMC01MS45Njg3NSAyNS45ODA0NjktMTVjNC43ODEyNS0yLjc2NTYyNSA2LjQyMTg3NS04Ljg3ODkwNiAzLjY2MDE1Ni0xMy42NjAxNTZsLTEzLjAwMzkwNi0yMi41MjM0MzdjMS41NTA3ODEtLjMwMDc4MiAxMS43NDYwOTMtMi4zMDA3ODIgMTkxLjUzOTA2Mi0zNy41NzAzMTMgMjIuMjI2NTYzLTEuMjA3MDMxIDM1LjU0Mjk2OS0yNS41MTU2MjUgMjQuMzE2NDA3LTQ0Ljk0OTIxOWwtMzMuMjM0Mzc2LTU3LjU2MjUgMjEuMjM4MjgyLTMyLjE2Nzk2OGMyLjA4NTkzNy0zLjE2NDA2MyAyLjIxMDkzNy03LjIzMDQ2OS4zMTY0MDYtMTAuNTExNzE5bC0yMC0zNC42NDA2MjVjLTEuODk0NTMxLTMuMjgxMjUtNS40OTIxODgtNS4yMDMxMjUtOS4yNjE3MTktNC45ODA0NjlsLTM4LjQ3MjY1NiAyLjMwODU5NC0zNi44OTQ1MzEtNjMuOTA2MjVjLTUuMzQzNzUtOS4yNTc4MTMtMTQuOTE3OTY5LTE0Ljg2MzI4MS0yNS42MDU0NjktMTQuOTk2MDk0LS4xMjg5MDYtLjAwMzkwNi0uMjUzOTA2LS4wMDM5MDYtLjM4MjgxMy0uMDAzOTA2LTEwLjMyODEyNCAwLTE5LjcwMzEyNCA1LjE0MDYyNS0yNS4yNTc4MTIgMTMuODMyMDMxbC0xMzAuNjMyODEyIDE2Ni40MTQwNjItODQuOTI1NzgyIDQ5LjAzMTI1Yy0zMy40MDIzNDQgMTkuMjc3MzQ0LTQ0Ljk3MjY1NiA2Mi4xMjg5MDctMjUuNjIxMDk0IDk1LjYyMTA5NCAxNy42Nzk2ODggMzAuNjI1IDU0Ljk1MzEyNiA0Mi42NzE4NzUgODYuNjAxNTYzIDMwem0xMDIuMzI0MjE5IDU3LjIzODI4MmM1LjUyMzQzNyA5LjU1NDY4NyAyLjI1MzkwNiAyMS43ODEyNS03LjMyODEyNSAyNy4zMTY0MDYtOS42MTMyODEgNS41NTg1OTQtMjEuODU1NDY5IDIuMTQ0NTMxLTI3LjMxNjQwNy03LjMyMDMxM2wtNTAtODYuNjEzMjgxIDM0LjY0MDYyNi0yMGM1Ny44NjcxODcgMTAwLjI0MjE4OCA0OS4wNzQyMTggODUuMDExNzE5IDUwLjAwMzkwNiA4Ni42MTcxODh6bS0yMi42ODM1OTQtNzkuMjk2ODc2LTEwLTE3LjMyMDMxMiAxNy4zMjAzMTItMTAgMTAgMTcuMzIwMzEyem0xOTYuNTgyMDMxLTIzNS45MTAxNTYgMTMuODIwMzEzIDIzLjkzNzUtMTIuMzI0MjE5IDE4LjY2NDA2My0yMy44MjAzMTMtNDEuMjYxNzE5em0tMTA0LjkxNzk2OS03Mi4xMzI4MTJjMi42ODM1OTQtNC4zOTA2MjUgNi45NDE0MDctNC44NDM3NSA4LjY2Nzk2OS00Ljc5Njg3NSAxLjcwNzAzMS4wMTk1MzEgNS45NjA5MzguNTUwNzgxIDguNTI3MzQ0IDQuOTk2MDkzbDExNi4zMTI1IDIwMS40NjQ4NDRjMy43ODkwNjMgNi41NTg1OTQtLjgxNjQwNiAxNC44MDQ2ODgtOC40MTQwNjMgMTQuOTkyMTg4LTEuMzYzMjgxLjAzMTI1LTEuOTkyMTg3LjI3NzM0NC01LjQ4NDM3NC45Mjk2ODdsLTEyMy4wMzUxNTctMjEzLjEwNTQ2OWMyLjU4MjAzMS0zLjMyMDMxMiAyLjkxNDA2My0zLjY0MDYyNCAzLjQyNTc4MS00LjQ4MDQ2OHptLTE2LjczNDM3NCAyMS40MzM1OTQgMTE1LjU5NzY1NiAyMDAuMjIyNjU2LTE3NC40NjA5MzggMzQuMjE4NzUtNTMuMDQ2ODc1LTkxLjg3ODkwNnptLTIyMy44NTE1NjMgMjY4LjY2Nzk2OGMtNC4zOTA2MjUtNy41OTc2NTYtNi43MTA5MzctMTYuMjIyNjU2LTYuNzEwOTM3LTI0Ljk0OTIxOCAwLTE3LjgzNTkzOCA5LjU4NTkzNy0zNC40NDUzMTMgMjUuMDExNzE4LTQzLjM1MTU2M2w3Ny45NDE0MDYtNDUgNTAgODYuNjAxNTYzLTc3Ljk0MTQwNiA0NS4wMDM5MDZjLTIzLjg3ODkwNiAxMy43ODEyNS01NC41MTU2MjUgNS41NzAzMTItNjguMzAwNzgxLTE4LjMwNDY4OHptMCAwIiBmaWxsPSIjMWUwNDcxIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIi8+PHBhdGggeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBkPSJtMTA1Ljk4NDM3NSAzMTQuNTc0MjE5Yy0yLjc2MTcxOS00Ljc4MTI1LTguODc4OTA2LTYuNDIxODc1LTEzLjY2MDE1Ni0zLjY2MDE1N2wtMTcuMzIwMzEzIDEwYy00Ljc3MzQzNyAyLjc1NzgxMy0xMC45MDIzNDQgMS4xMTMyODItMTMuNjYwMTU2LTMuNjYwMTU2LTIuNzYxNzE5LTQuNzgxMjUtOC44Nzg5MDYtNi40MjE4NzUtMTMuNjYwMTU2LTMuNjYwMTU2cy02LjQyMTg3NSA4Ljg3ODkwNi0zLjY2MDE1NiAxMy42NjAxNTZjOC4yMzA0NjggMTQuMjU3ODEzIDI2LjU4OTg0MyAxOS4yODUxNTYgNDAuOTgwNDY4IDEwLjk4MDQ2OWwxNy4zMjAzMTMtMTBjNC43ODEyNS0yLjc2MTcxOSA2LjQyMTg3NS04Ljg3NSAzLjY2MDE1Ni0xMy42NjAxNTZ6bTAgMCIgZmlsbD0iIzFlMDQ3MSIgZGF0YS1vcmlnaW5hbD0iIzAwMDAwMCIgc3R5bGU9IiIgY2xhc3M9IiIvPjxwYXRoIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgZD0ibTQ5Ny4xMzY3MTkgNDMuNzQ2MDk0LTU1LjcyMjY1NyAzMS4wMDc4MTJjLTQuODI0MjE4IDIuNjg3NS02LjU2MjUgOC43NzczNDQtMy44NzUgMTMuNjAxNTYzIDIuNjc5Njg4IDQuODIwMzEyIDguNzY1NjI2IDYuNTY2NDA2IDEzLjYwMTU2MyAzLjg3NWw1NS43MTg3NS0zMS4wMDc4MTNjNC44MjgxMjUtMi42ODc1IDYuNTYyNS04Ljc3NzM0NCAzLjg3NS0xMy42MDE1NjItMi42ODM1OTQtNC44MjgxMjUtOC43NzM0MzctNi41NjI1LTEzLjU5NzY1Ni0zLjg3NXptMCAwIiBmaWxsPSIjMWUwNDcxIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIi8+PHBhdGggeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBkPSJtNDkxLjI5Mjk2OSAxNDcuMzE2NDA2LTM4LjYzNjcxOS0xMC4zNTE1NjJjLTUuMzM1OTM4LTEuNDI5Njg4LTEwLjgyMDMxMiAxLjczNDM3NS0xMi4yNSA3LjA3MDMxMi0xLjQyOTY4OCA1LjMzNTkzOCAxLjczODI4MSAxMC44MTY0MDYgNy4wNzQyMTkgMTIuMjQ2MDk0bDM4LjY0MDYyNSAxMC4zNTE1NjJjNS4zNjcxODcgMS40NDE0MDcgMTAuODI0MjE4LTEuNzczNDM3IDEyLjI0NjA5NC03LjA3MDMxMiAxLjQyOTY4Ny01LjMzNTkzOC0xLjczODI4Mi0xMC44MjAzMTItNy4wNzQyMTktMTIuMjQ2MDk0em0wIDAiIGZpbGw9IiMxZTA0NzEiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIHN0eWxlPSIiIGNsYXNzPSIiLz48cGF0aCB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGQ9Im0zOTQuMTk5MjE5IDcuNDE0MDYyLTEwLjM2MzI4MSAzOC42NDA2MjZjLTEuNDI5Njg4IDUuMzM1OTM3IDEuNzM0Mzc0IDEwLjgxNjQwNiA3LjA3MDMxMiAxMi4yNSA1LjMzMjAzMSAxLjQyNTc4MSAxMC44MTY0MDYtMS43MzA0NjkgMTIuMjUtNy4wNzAzMTNsMTAuMzU5Mzc1LTM4LjY0MDYyNWMxLjQyOTY4Ny01LjMzNTkzOC0xLjczNDM3NS0xMC44MjAzMTItNy4wNzAzMTMtMTIuMjUtNS4zMzIwMzEtMS40Mjk2ODgtMTAuODE2NDA2IDEuNzM0Mzc1LTEyLjI0NjA5MyA3LjA3MDMxMnptMCAwIiBmaWxsPSIjMWUwNDcxIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIi8+PC9nPjwvc3ZnPgo=" alt="" class="image">

      <div>You are currently...</div>

      @switch($mailData['status'])

        @case("PENDING")
       <!-- if processing -->
       <div class="pill" style="border: 2px solid #FFC107"><strong>PENDING</strong></div>
       <div style="margin-top: 50px">
         Your information has been received! Kindly wait for the admission team to verify and accept your information.
         <br><br><br>
         <strong>We'll get back to you!</strong>
       </div>
       @break


       @case("ACCEPTED")
       <!-- if accepted -->
       <div class="pill" style="border: 2px solid #3F51B5"><strong>ACCEPTED</strong></div>
       <div style="margin-top: 50px">
          You can now pay for your tuition and miscellaneous fee. Check your generated balance or submit your proof of payment at<br><a href="https://ictdevsms.azurewebsites.net/portal/payment"><strong>Student Portal > Payment</strong></a>
         <br><br><br>
         <strong>Good luck!</strong>
       </div>
       @break
 
       @case("ASSIGNED")
       <!-- if assigned -->
       <div class="pill" style="border: 2px solid #3F51B5"><strong>ASSIGNED</strong></div> 
       <div style="margin-top: 50px">
         You can now pay for your tuition and miscellaneous fee at the Accounting department.
         <br><br><br>
         <strong>Good luck!</strong>
       </div>
       @break
 
       @case("OFFICIAL")
       <!-- if official -->
       <div class="pill" style="border: 2px solid #3F51B5"><strong>OFFICIAL</strong></div>
       <div style="margin-top: 50px">
         You're officially a student! Visit <br>
           <a href="https://www.facebook.com/spcfofficial">
             SPCF Official Facebook Page
           </a> <br>
         for official announcements.
         <br><br><br>
         <strong>See you soon!</strong>
       </div>
       @break
 
       @case("DENIED")
       <!-- if denied -->
       <div class="pill" style="border: 2px solid #F44336"><strong>DENIED</strong></div>
       <div style="margin-top: 50px">
         Go to <a href="">SPCF Student Portal</a> to resubmit your denied information. The admission team will reprocess it again afterwards.
         <br><br><br>
         <strong>You can do this!</strong>
       </div>
       @break
 
       @case("ARCHIVED")
       <!-- if archived -->
       <div class="pill" style="border: 2px solid #F44336"><strong>ARCHIVED</strong></div>
       <div style="margin-top: 50px">
         We haven't heard from you for a while, so we archived your data to allot space for new applicants. But don't worry, you can still restore it within <strong>6 months</strong>.
         <br><br><br>
         <strong>Hope you make it!</strong>
       </div>
       @break


      @endswitch
      
    </div>
      
  </body>
  <footer class="text-center">
    <div style="font-size: 13px; margin-bottom: 50px;">For more information about your enrollment status, <br> go to 
      <!-- portal link -->
      <a href="https://ictdevsms.azurewebsites.net/portal">SPCF SMS Student Portal</a>
    </div>
    <div style="font-size: 14px;">
      <div>Contact Us</div>
      <div><strong>Systems Plus College Foundation</strong></div>
      <div>0922-832-7082 | 09190692914</div>
      <div>(045) 322-7723</div>
      <div>info@spcf.edu.ph</div>
    </div>
    <div style="font-size: 10px; margin-top: 50px">Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
  </footer>
</html>
