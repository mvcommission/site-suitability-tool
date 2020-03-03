<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Site Suitability Tool Introduction</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

	 <link rel="stylesheet" href="/css/app.css" /> 

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                /* color: #636b6f; */
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            /* .full-height {
                height: 100vh;
            } */

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                /* text-align: center; */
				max-width: 90%;
				margin:auto;
            }

            .title {
                font-size: 84px;
				text-align: center;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

			p.logo img {
				max-width:150px;
			}
        </style>
    </head>
    <body>
        <div class="">
            {{-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif --}}

            <div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="title m-b-md">
							Site Suitability Tool
						</div>
					</div>
				</div>
                <div class="row">
					<div class="col-md-10 offset-md-1 row">
						<div class="col-md-3">
							<p class="logo"><img src="/images/Edg_Seal_bw.jpg" /></p>
							<p class="logo"><img src="/images/Oak_Seal_bw.jpg" /></p>
							<p class="logo"><img src="/images/Tis_Seal_bw.jpg" /></p>
							<p class="logo"><img src="/images/Wti_Seal_bw.jpg" /></p>
							<p class="logo"><img src="/images/MVC_futura_crop.jpg" /></p>

						</div>
					<div class="col-md-9">
						<p>Siting of affordable housing at different densities is a widely acknowledged need across Edgartown, Oak Bluffs, Tisbury and West Tisbury.  To help address this, the Martha’s Vineyard Commission contracted with Bluegear Labs with a grant from the State’s Office of Energy and Environmental Affairs to develop a Site Suitability Tool for housing.  </p>
						<p>There are numerous datasets embedded in the tool whose weights can be customized by user preference.  These preferences will impact scores assigned to parcels across a given town, once an analysis is generated.  Scores will reflect preliminary site suitability for various densities of housing development.  The aim here is to provide you a practical way to integrate your town knowledge so that site scores truly reflect local interests.</p>
						<p>The mapping interface component will afford you, as the user, the ability to cross reference site locations and their respective scores paired within a larger neighborhood context, while assessing the distribution or concentration of these sites.   We hope this tool can serve as a resource for periodic reference as well as enable quantitative comparison of sites across towns and between individual sites – with analysis that accounts for regulatory and community forces that shape local development decisions.   </p>

						<h3>Instructions</h3>
						<p>Please be aware that this application is in beta and still actively being developed. One of the known issues is the extended loading time. After selecting a town from the dropdown, we recommend using the filters to limit the number of results in order to speed up the calculations and performance.</p>
						<ol>
							<li>You can view informational map layers or the map legend using the buttons in the right column.</li>
							<li>To begin using the tool, select a town from the drop-down menu.</li>
							<li>While the data is loading, you will seeing a Loading icon at the top of the screen. Once the data is fully loaded and the map updated, the icon will disappear.</li>
							<li>If there is an error while loading the data, you will see an alert icon and message. You can dismiss the alert and try again. If the error persists, we recommend refreshing the page.</li>
							<li>You can click on a parcel on the map to view basic information about the parcel. </li>
							<li>To limit the number of results, use the filters to find a parcel by address, Map & Lot ID, or minimum number of bedrooms.</li>
							<li>You can adjust the scoring factors by dragging the slider for each of the factors. Dragging a slider to the left will minimize the factor's impact on the parcel's total score.</li>
							<li>Currently, the factors available for scoring are: 
								<ul>
									<li>Zoning Density (points allocated for the parcel's zoning regulation).</li>
									<li>Pts / Bedroom (points allocated per bedroom as of right)</li>
									<li>Vacant Lot (points allocated for a vacant lot as determined by a building value of less than $25,000)</li>
									<li>Assessed Value (points allocated for the parcel's assessed value).</li>
									<li>Historic District (wether or not the parcel is within the town's Historic District)</li>
									<li>Overlay Zoning (whether or not the parcel overlaps a potentially restrictive zone such as DCPC or water resource protection)</li>
									<li>Watershed Condition</li>											
									<li>NHESP Priority Habitat</li>
									<li>Wetlands</li>
									<li>Sewered parcels</li>
									<li>Town Water parcels</li>
									<li>Proximity to public bus routes</li>
											<li>Proximity to Business District</li>
											<li>Proximity to Shared Use Paths</li>	
								</ul>
							</li>
							
							<li>After you have adjusted the scoring factors, click the Calculate button to run the calculations and update the parcels' scores.</li>
							<li>To view all details for a parcel, click the <i class="fas fa-plus"></i> button in the results row.</li>
							<li>To reset the filters and view all parcels for the selected town, click the "Reset Filters" button above the results.</li>
							<li>To select parcels for comparison, scroll down to the Results table and click on the checkbox next to the parcels you'd like to compare. When you have finished selecting parcels, click the "View Selected Parcels" button that appears next to the map in the right sidebar.</li>
							<li>To export the data as a .xls worksheet, click on either the "Download All Results" or "Download Filtered Results" and you will be prompted to download the file. You may see a warning about the format of the file and the file extension not matching when you open the file - click "Yes" and then click "Ok" when prompted about opening the Web Page as an Excel document.</li>
							
						</ol>
						<p><a href="/map" class="btn btn-primary">Get Started </a></p>
				</div>

					</div>
				</div>
            </div>
        </div>
    </body>
</html>
