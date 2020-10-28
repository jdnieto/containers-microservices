import os
import datetime
from flask import Flask, jsonify
from flask_sqlalchemy import SQLAlchemy
from project.config import *

# instantiate the db
db = SQLAlchemy()

def create_app(script_info=None):

    # instantiate the app
    app = Flask(__name__)

    #set config
    app_settings = os.getenv('APP_SETTINGS')
    app.config.from_object(app_settings)

    # setup extensions
    db.init_app(app)

    from project.api.tareas import tareas_blueprint
    app.register_blueprint(tareas_blueprint)

    app.shell_context_processor({'app': app, 'db': db})
    return app
