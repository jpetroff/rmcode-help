# collect client-side scripts from node_modules
fs = require 'fs-extra'
path = require 'path'
minimatch = require 'minimatch'
_ = require 'underscore'

NODE_MODULES = 'node_modules'

locate = {
	'admin': {
		'**/*.css': 'admin_src/libs/css'
		'**/*.js': 'admin_src/libs/js'
	},
	'front': {
		'**/*.css': 'frontend_src/libs/css'
		'**/*.js': 'frontend_src/libs/js'
	}
}

list = {
	'admin': [
		'normalizecss',
		'underscore',
		'vue',
		'showdown'],
	'front': [
		'normalizecss',
		'underscore',
		'vue',
	]
}

defDist = {
	'vue': 'dist/vue.min.js'
	'underscore': 'underscore-min.js',
	'vuelidate': 'dist/vuelidate.min.js',
	'vuelidate': 'dist/validators.min.js',
	'showdown': 'dist/showdown.min.js'
}

runThrough = (obj, file) ->
	for own key, val of obj
		console.log key, val, file
		return val if minimatch(file, key)
	
	return ''

processPackage = (lib, data) ->
	if data == null
		main = path.join NODE_MODULES, lib, defDist[lib]
	else
		contents = JSON.parse data
		main = path.join NODE_MODULES, lib, contents.main
	
	destLocation = runThrough locate[args[0]], main
	destName = path.parse(main).base
	
	destination = path.join destLocation, destName
	
	console.log main, destination
	
	fs.copy main, destination, (err) ->
		if err
			console.log err
			return
		
		console.log '→ success!'


args = process.argv.slice 2
if args.length == 0 || !list[args[0]]
	console.log ('Specify bundle task: admin or front');
	return;

_list = list[args[0]]

_.each _list, (lib) ->
	console.log '[PACKAGE] ' + lib
	
	if not defDist[lib]
		tryBower = path.join NODE_MODULES, lib, 'bower.json'
		tryPackage = path.join NODE_MODULES, lib, 'package.json'
		console.log 'trying bower.json...'
		fs.readFile tryBower, (err, data) ->
			if err
				console.log 'trying package.json...'
				fs.readFile tryPackage, (err, data) ->
					if err
						console.log 'Skipped...'
						return
					
					processPackage lib, data
				
				return
			
			processPackage lib, data
			return
	
	else
		processPackage lib, null
	
	console.log '\n'