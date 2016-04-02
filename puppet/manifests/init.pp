exec { 'apt-get update':
  path => '/usr/bin',
}

package { ['nano','git','ant']:
  ensure => present,
}

class { 'memcached': }
class { 'php': }
class { 'nginx': }
class { 'mysql': }