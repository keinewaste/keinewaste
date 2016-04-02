class memcached {
  package { [
             'memcached'
             ]:
    ensure => present,
    require => Exec['apt-get update'],
  }

  # Make sure php5-fpm is running
  service { 'memcached':
    ensure => running,
    require => Package['memcached'],
  }
}
