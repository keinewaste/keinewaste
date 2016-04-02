class php {

  # Install the php5-fpm and php5-cli packages
  package { ['php5-fpm',
             'php5-cli',
             'php5-gd',
             'php5-memcached',
             'php5-memcache',
             'php5-redis',
             'php5-mysql',
             'php5-intl',
              'php5-curl',
              'php5-xdebug'
             ]:
    ensure => present,
    require => Exec['apt-get update'],
  }

  # Make sure php5-fpm is running
  service { 'php5-fpm':
    ensure => running,
    require => Package['php5-fpm'],
  }

}
