@extends('mjml::base')

@section('head')
    <mj-attributes>
        @if(!empty($previewText))
            <mj-preview>{{ $previewText }}</mj-preview>
        @endif
        <mj-font name="Roboto" href="https://fonts.googleapis.com/css?family=Roboto" />
        <mj-all font-family="Roboto, Arial, Helvetica, sans-serif" />

        <!-- Components -->
        <mj-body background-color="#F2F2F2" width="700px" />
        <mj-section background-color="#FFF" />
        <mj-wrapper padding="0px" />

        <mj-text align="left" font-size="21px" line-height="30px" color="#30324B" />

        <mj-button inner-padding="15px 20px"
                   border-radius="4px"
                   background-color="#EF5185"
                   color="white"
                   font-weight="500"
                   text-transform="uppercase"
                   font-size="15px"
                   letter-spacing="1px"
                   line-height="21px"
                   css-class="button" />

        <mj-spacer height="30px" />

        <!-- Colors -->
        <mj-class name="brand-grey" background-color="#F2F2F2" />

        <mj-class name="brand-dark-blue" background-color="#43455F" />

        <!-- Class Attribute -->
        <mj-class name="body" padding-left="20px" padding-right="20px" padding-top="0px" padding-bottom="0px" />

        <mj-class name="title-wrapper" width="80%" padding-top="25px" padding-bottom="5px" />

        <mj-class name="left-column" width="55%" padding-bottom="25px" />

        <mj-class name="right-column" width="45%" />

        <mj-class name="container-title"
                  font-size="13px"
                  line-height="18px"
                  color="#30324B"
                  letter-spacing="0.2px"
                  font-weight="700"
                  text-transform="uppercase"	/>

        <mj-class name="container"
                  font-size="15px"
                  line-height="21px"
                  color="#30324B"
                  font-weight="400"
                  line-color="#028489"
                  padding-top="0" />

        <mj-class name="paragraph"
                  font-size="15px"
                  line-height="21px"
                  font-weight="400"
                  color="#30324B" />

        <mj-class name="paragraph--small"
                  font-size="13px" font-weight="400"
                  padding="25px"
                  line-height="18px"
                  color="#EF5185" />

        <mj-class name="calendar-link"
                  background-color="#4E888C"
                  width="250px"
                  font-size="11px"
                  inner-padding="15px 20px" />

        <mj-class name="mjml-button--lower"
                  inner-padding="15px 20px"
                  border-radius="4px"
                  background-color="#EF5185"
                  color="white"
                  font-weight="500"
                  text-transform="uppercase"
                  font-size="15px"
                  letter-spacing="1px"
                  line-height="21px"
                  align="left"
                  padding-bottom="0"
                  padding-top="0"
                  css-class="button" />

        <mj-class name="mjml-button--upper"
                  inner-padding="15px 20px"
                  border-radius="4px"
                  background-color="#EF5185"
                  color="white"
                  font-weight="500"
                  text-transform="uppercase"
                  font-size="15px"
                  letter-spacing="1px"
                  line-height="21px"
                  align="left"
                  padding-bottom="28px"
                  width="100%"
                  padding-top="0"
                  css-class="button" />

    </mj-attributes>
    <mj-style>
        @media only screen and (min-width:480px) {
        .title {
        font-size: 40px !important;
        line-height: 50px !important;
        }
        }
        @media only screen and (max-width: 480px) {
        .hide-on-mobile {
        display: none !important;
        }
        }

        .list-title {
        font-weight: 700;
        color: #30324B;
        }

        .button--lower table {
        min-width: 80%;
        }

        .faq--link {
        color: #4E888C !important;
        }
    </mj-style>

    <mj-style inline="inline">
        a {
        color: #30324B;
        }

        .button {
        letter-spacing: 1px;
        }

        .title {
        text-align: center;
        color: #30324B;
        font-family: Roboto, Arial, Helvetica, sans-serif;
        font-size: 27px;
        line-height: 33px;
        font-weight: bold;
        }

        ul {
        padding-left: 18px;
        }

        li {
        padding-bottom: 10px;
        }

        .wrap-text {
        padding: 18px;
        background-color: #F9F9F9;
        white-space: pre-line;
        word-wrap: break-word;
        }

        .date-time {
        padding: 18px;
        background-color: #F9F9F9;
        word-wrap: break-word;
        text-align: center;
        display: inline-block;
        }

        .date {
        font-size: 21px;
        line-height: 30px;
        color: #EF5185;
        margin-bottom: 14px;
        text-transform: uppercase;
        }

        .time {
        font-weight: bold;
        font-size: 13px;
        line-height: 18px;
        color: #30324B;
        letter-spacing: 0.5px;
        }

        .right-column {
        padding: 25px;
        background-color: #F2F2F2;
        }
    </mj-style>
@endsection


@section('body')
    <mj-section mj-class="brand-grey" >
        <mj-column>
            <mj-text>{{ config('site.name') }}</mj-text>
        </mj-column>
    </mj-section>

    <mj-section>
        <mj-column mj-class="title-wrapper">
            <mj-text>
                <div class="title">
                    {{ $title }}
                </div>
            </mj-text>
        </mj-column>
    </mj-section>

    <!-- Body -->
    <mj-section mj-class="body">
        @yield('main')
    </mj-section>

    <mj-section full-width="full-width" padding-top="40px">
    </mj-section>
    <mj-section full-width="full-width" mj-class="brand-dark-blue" padding-top="40px" padding-bottom="40px">
        <mj-column >
            <mj-text align="center" padding="6px" color="#fff" font-size="13px" line-height="18px">
                <a style="color: inherit" href="{{ config('app.url') }}/privacy">Privacy</a>   |
                <a style="color: inherit" href="{{ config('app.url') }}/terms-and-conditions">Terms & Conditions</a>   |
                <a style="color: inherit" href="{{ config('app.url') }}/get-in-touch">Contact Us</a>
            </mj-text>
            <mj-text align="center" padding="6px"  color="#fff" font-size="13px" line-height="18px">
                © {{ config('app.name') }} {{ date('Y') }}.
            </mj-text>
        </mj-column>
    </mj-section>
@endsection


