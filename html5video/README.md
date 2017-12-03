#SilverStripe HTML5Video

SilverStripe HTML5Video is a [SilverStripe](http://silverstripe.org) module to add HTML5 Video to your website. 

Features include:

*	Upload MP4, WebM and Ogg formats
*	[VideoJS](http://videojs.com) video player
*	Flash fallback for old browsers

## Installation

### Requirements

*	SilverStripe 3.1.x or higher

### Composer Installation

`"require": { "dynamic/silverstripe-html5video": "*" }`

### Git Installation

`git clone git@github.com:dynamic/silverstripe-html5video.git html5video`

### Recommended Add-Ons

The following add-ons are optional, but will enhance HTML5Video when installed:

*	[SilverStripe ChunkedUploadField](https://github.com/micschk/silverstripe-chunkeduploadfield) allows for large file uploads

## Setup

Once HTML5Video is installed, run a dev/build to setup the database.

## Use

Create a VideoGroup page in the CMS. Add HTML5Video pages as sub pages and upload your videos. VideoGroup will show previews of all child videos, and will link to each HTML5Video page to view the video. 

## Config

VideoGroup has configuration options you can override in your `config.yml` file: 

*	`page_length` - Videos per page. Default is `12`
*	`pagination_get_var` - GET variable used for pagination links. Default is `s`
*	`include_child_groups` - Include videos of nested VideoGroups. Default is `true`


```
VideoGroup:
  page_length: 9
  pagination_get_var: start
  include_child_groups: false
```


## Additional Information

### Maintainer Contact

 *  [Dynamic](http://www.dynamicagency.com) (<dev@dynamicagency.com>)
 
### Links

 * [SilverStripe ChunkedUploadField](https://github.com/micschk/silverstripe-chunkeduploadfield)
 * [VideoJS](http://videojs.com)
   
## License

	Copyright (c) 2015, Dynamic Inc
	All rights reserved.

	Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

	Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
	
	Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
	
	THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
