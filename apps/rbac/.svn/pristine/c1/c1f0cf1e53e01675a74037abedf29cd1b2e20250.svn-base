#!/usr/bin/env bash

#  -----------------------------------
#  本脚本为公共自动任务
#  author  Kevin
# -----------------------------------

#引入配置文件
. ./config

while true;
do
	# 同步所有平台, 帐号
	run_action "cron -m auth -a run" > /dev/null 2>&1 &

	# 休息一会
	sleep 600
done
