from flask import Blueprint, jsonify, request, abort
from project.api.models import Tareas
from project import db
from sqlalchemy import exc
from functools import wraps
import os

tareas_blueprint = Blueprint('tareas', __name__)
def require_appkey(view_function):
    @wraps(view_function)
    def decorated_function(*args, **kwargs):
        if request.headers.get('x-api-key') and request.headers.get('x-api-key') == os.environ['API_KEY']:
            return view_function(*args, **kwargs)
        else:
            abort(401, jsonify({'stratus':'success',
                'message': 'You are not authorized!'}))
    return decorated_function

@tareas_blueprint.route('/tareas/ping', methods=['GET'])
def ping_pong():
    return jsonify({
        'status': 'success',
        'message': 'pong!'
    })

@tareas_blueprint.route('/tareas/agregar', methods=['POST'])
@require_appkey
def add_tarea():
    post_data = request.get_json()
    response_object = {
        'status': 'fail',
        'message': request.get_json()
    }
    if not post_data:
        return jsonify(response_object), 400
    tarea = post_data.get('tarea')
    try:
            db.session.add(Tareas(tarea=tarea))
            db.session.commit()
            response_object = {
                'status': 'success',
                'message': '"' + tarea + '" was added!'
            }
            return jsonify(response_object), 201
    except exc.IntegrityError as e:
        db.session.rollback()
        return jsonify(response_object), 400


@tareas_blueprint.route('/tareas', methods=['GET'])
def get_all_tareas():
    """ Get all tareas """
    response_object = {
        'status': 'success',
        'data':{
            'tareas': [tarea.to_json() for tarea in Tareas.query.all()]
        }
    }
    return jsonify(response_object), 200

@tareas_blueprint.route('/tareas/borrar/<tarea_id>', methods=['DELETE'])
@require_appkey
def remove_tarea(tarea_id):
    """ Remove tarea """
    response_object = {
        'status': 'fail',
        'message': 'Tarea does not exist'
    }
    try:
        tarea = Tareas.query.filter_by(id=tarea_id).first()
        if not tarea:
            return jsonify(response_object), 404
        else:
            db.session.delete(tarea)
            db.session.commit()
            response_object = {
                'status': 'success',
                'message': 'Tarea "'+ tarea_id+'" removed'
            }
            return jsonify(response_object), 200
    except exc.DataError as e:
        return jsonify(response_object), 404

@tareas_blueprint.route('/tareas/limpiar', methods=['DELETE'])
@require_appkey
def clean_tarea():
    """ Clean tarea """
    response_object = {
        'status': 'fail',
        'message': 'An error has been risen'
    }
    try:
            db.session.execute('TRUNCATE TABLE tareas')
            db.session.commit()
            response_object = {
                'status': 'success',
                'message': 'Cleaned tareas'
            }
            return jsonify(response_object), 200
    except exc.DataError as e:
        return jsonify(response_object), 404
