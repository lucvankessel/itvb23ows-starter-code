pipeline {
    agent any

    environment {
        SONARQUBE_SCANNER_HOME = tool 'SonarQube-scanner'
    }

    stages {

        stage('SCM') {
            steps {
                checkout scm
            }
        }

        stage('SonarQube Analysis') {
            steps {
                withSonarQubeEnv('SonarQube') {
                    sh "${SONARQUBE_SCANNER_HOME}/bin/sonar-scanner"
                }
            }
        }

        stage('test') {
            agent {
                docker {
                    image 'composer:lts'
                }
            }
            steps {
                sh 'composer install'
                sh 'vendor/bin/phpunit src/.'
            }
        }

        stage('build') {
            agent { 
                docker { 
                    image 'php:8.3.0-alpine3.19' 
                    } 
                }
            steps {
                sh 'php --version'
            }
        }
    }
}