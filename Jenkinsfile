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
            steps {
                script {
                    def dockerBuildExitCode = sh(script: 'docker build -t my-php-app .', returnStatus: true)
                    
                    if (dockerBuildExitCode == 0) {
                        echo 'Docker build successful!'
                    } else {
                        error 'Docker build failed!'
                    }
                }
            }
        }
    }
}