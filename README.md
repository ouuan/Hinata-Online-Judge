<p align="center"><img src="./web/images/logo.png?raw=true" alt="logo"></p>

# Hinata Online Judge

Hinata Online Judge 是 ouuan 基于社区版 UOJ 搭建的校内 OJ。

[feature list](https://github.com/ouuan/Hinata-Online-Judge/issues/1)

~~使用方法：首先你需要已经安装了 [社区版 UOJ](https://github.com/UniversalOJ/UOJ-System)。在 docker 内的 `/opt/uoj` 文件夹下就是一个 git 仓库，如果要使用所有 feature 直接 pull 本仓库即可。即：~~

本 fork 魔改程度很大，而且有的改动并没有太考虑其他人的使用。建议本 fork 仅作为魔改的参考，可以从这里复制代码 / 找到思路，但不建议直接使用本 fork。

1. （docker 外）`sudo docker exec -it uoj /bin/bash`

2. `cd /opt/uoj`

3. `git remote add hinata https://github.com/ouuan/Hinata-Online-Judge.git`

4. `git pull hinata master`

如果有冲突可能要手动解决。

安装前建议备份（`docker commit uoj`）。

由于 [题目统计页面支持按提交时间和内存使用排序](https://github.com/ouuan/Hinata-Online-Judge/commit/a44d1923a033dfe320388cc657cf0ac9a16af4ab)，安装后，请在系统管理页面的 MySQL 管理一栏点击 “更新数据库” 按钮。

# Universal Online Judge

> #### 一款通用的在线评测系统。

## 特性

- 前后端全面更新为 Bootstrap 4 + PHP 7。
- 多种部署方式，各取所需、省心省力、方便快捷。
- 各组成部分可单点部署，也可分离部署；支持添加多个评测机。
- 题目搜索，全局放置，任意页面均可快速到达。
- 所有题目从编译、运行到评分，都可以由出题人自定义。
- 引入 Extra Tests 和 Hack 机制，更加严谨、更有乐趣。
- 支持 OI/IOI/ACM 等比赛模式；比赛内设有提问区域。
- 博客功能，不仅可撰写图文内容，也可制作幻灯片。

## 文档

有关安装、管理、维护，可参阅：[https://universaloj.github.io/](https://universaloj.github.io/)

## 感谢

- [vfleaking](https://github.com/vfleaking) 将 UOJ 代码[开源](https://github.com/vfleaking/uoj)
- 向原项目或本项目贡献代码的人
- 给我们启发与灵感以及提供意见和建议的人

