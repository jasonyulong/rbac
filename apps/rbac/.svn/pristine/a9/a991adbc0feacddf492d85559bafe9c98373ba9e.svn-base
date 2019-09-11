#!/usr/bin/env bash

#  -----------------------------------
#  本脚本为所有同步到ERP的自动任务
#  author  Kevin
# -----------------------------------

#引入配置文件
. ./config

while true;
do
    # 同步用户数据到ERP
    grepUsers="toerp -m users -a run"

	# 根据关键词查找已运行进程数量,小于1个进程则可运行
    count=`ps -ef | grep "$grepUsers" | grep -v "grep" | wc -l`
    if [[ $count -le 0 ]]; then
        $phpBin $phpRun $grepUsers > /dev/null 2>&1 &
    fi

    # 同步用户数据到ERP
    grepOrg="toerp -m organization -a run"

	# 根据关键词查找已运行进程数量,小于1个进程则可运行
    count=`ps -ef | grep "$grepOrg" | grep -v "grep" | wc -l`
    if [[ $count -le 0 ]]; then
        $phpBin $phpRun $grepOrg > /dev/null 2>&1 &
    fi

	# 休息一会
	sleep 3600
done